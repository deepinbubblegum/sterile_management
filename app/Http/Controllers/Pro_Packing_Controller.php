<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use PDF;
use QrCode;

use Illuminate\Support\Facades\File;

use App\Http\Controllers\OnProcess_controller;

class Pro_Packing_Controller extends BaseController
{

    private function AutuIDPacking()
    {
        $oid = DB::select(
            'SELECT CONCAT("PAC-",LPAD(SUBSTRING(IFNULL(MAX(packing.packing_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM packing'
        );
        return $oid[0]->auto_id;
    }


    private function AutuIDsterile()
    {
        $oid = DB::select(
            'SELECT CONCAT("STE-",LPAD(SUBSTRING(IFNULL(MAX(sterile_qc.sterile_qc_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM sterile_qc'
        );
        return $oid[0]->auto_id;
    }


    private function AutuIDImg()
    {
        $oid = DB::select(
            'SELECT CONCAT("IMG_PAC-",LPAD(SUBSTRING(IFNULL(MAX(packing_img.image_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM packing_img'
        );
        return $oid[0]->auto_id;
    }


    public function OnProcess_Getsterile_machine(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items_machine = DB::table('machine')
                ->select('machine.*')
                ->get();

            $items_program = DB::table('machine_programs')
                ->select('machine_programs.*', 'programs.Program_name')
                ->leftjoin('programs', 'machine_programs.Program_id', '=', 'programs.Program_id')
                ->get();

            $items_process = DB::table('machine')
                ->select('machine.Machine_type')
                ->distinct('machine.Machine_type')
                ->get();

            $return_data->code = '0000';
            $return_data->items_machine = $items_machine;
            $return_data->items_program = $items_program;
            $return_data->items_process = $items_process;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_GetPacking_List(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('packing')
                ->select('packing.*', 'equipments.Name', 'machine.Machine_name', 'programs.Program_name', 'machine_programs.Program_id', 'users.Name as UserName_QC', 'items.Quantity', 'items.Item_status')
                ->leftjoin('items', 'items.item_id', '=', 'packing.item_id')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('machine', 'packing.Machine_id', '=', 'machine.Machine_id')
                // ->leftjoin('machine_programs', 'machine.Machine_id', '=', 'machine_programs.Machine_id')
                ->leftJoin('machine_programs', function ($join) {
                    $join->on('machine.Machine_id', '=', 'machine_programs.Machine_id');
                    $join->on('packing.Program_id', '=', 'machine_programs.Program_id');
                })
                ->leftjoin('programs', 'machine_programs.Program_id', '=', 'programs.Program_id')
                ->leftjoin('users', 'packing.Qc_by', '=', 'users.User_id')
                ->where('packing.Order_id', $data['OrderId'])
                ->orderBy('packing_id')
                ->get();

            $return_data->code = '0000';
            $return_data->Packing_List = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    private function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if ($val['Cycle'] == null || $val['Cycle'] == '' || $val['Cycle'] == "null") {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
            }

            $i++;
        }
        return $temp_array;
    }


    public function OnProcess_New_PackingList(Request $request)
    {

        $return_data = new \stdClass();

        try {

            $data = $request->all();
            $dateNow = Carbon::now();

            $CUS_ID = DB::table('orders')
                ->select('orders.*')
                ->where('Order_id', $data['OrderId'])
                ->get();
            // dd($CUS_ID[0]->Customer_id);


            // dd($Cycle_Customer[0]->maxCycle);

            // $index = (int)$Cycle_Customer[0]->maxCycle;
            // $mach_cycle = array();
            $new_mach_cycle = collect([]);
            $Cycle_ma = $this->unique_multidim_array($data['PackingItem'], 'Machines_id');
            foreach ($Cycle_ma as $item_Cycle) {
                // $item_Cycle->name = "My name";
                // $index++;

                $Cycle_Customer = DB::table('packing')
                    ->selectRaw('max(Cycle) as maxCycle')
                    ->leftjoin('orders', 'packing.Order_id', '=', 'orders.Order_id')
                    ->where('orders.Customer_id', $CUS_ID[0]->Customer_id)
                    ->where('Machine_id', $item_Cycle['Machines_id'])
                    // ->whereMonth('packing.Create_at', '=', now()->month)
                    ->whereDate('packing.Create_at', Carbon::today())
                    ->get();

                $index = (int)($Cycle_Customer[0]->maxCycle) + 1;

                $new_mach_cycle->push([
                    'Machines_id' => $item_Cycle['Machines_id'],
                    'cycle' => $index
                ]);
            }
            // dd($new_mach_cycle);
            // dd();


            foreach ($data['PackingItem'] as $item) {

                $packing_id = $item['packing_id'];


                if ($packing_id == 'null' || $packing_id == null || $packing_id == '' || $packing_id == '-') {
                    $packing_id = $this->AutuIDPacking();
                }


                $Exp_date = $item['Exp'];
                if ($Exp_date == 'null' || $Exp_date == null || $Exp_date == '' || $Exp_date == '-') {
                    $Exp_date = Carbon::now()->addDay($item['AddExp']);
                }
                // dd($dateNow);

                $num_cycle =  $item['Cycle'];
                if ($item['Cycle'] == null || $item['Cycle'] == 'null' || $item['Cycle'] == '') {

                    $num_cycle = $new_mach_cycle->where('Machines_id', '==', $item['Machines_id'])->values()[0]['cycle'];
                }
                // dd($item['Cycle']);

                DB::table('packing')->updateOrInsert(
                    [
                        'packing_id' => $packing_id,
                        'Order_id' => $data['OrderId'],
                        'item_id' => $item['item_id'],
                    ],
                    [
                        // 'packing_id' => $packing_id,
                        // 'Order_id' => $data['OrderId'],
                        // 'item_id' => $item['item_id'],
                        // 'Cycle' => $num_cycle,
                        // 'QTY' => $item['QTY'],
                        // 'PassStatus' => $item['check'],
                        // 'Create_at' => $dateNow,
                        'Order_id' => $data['OrderId'],
                        'item_id'  => $item['item_id'],
                        'Machine_id' => $item['Machines_id'],
                        'Program_id' => $item['program_id'],
                        'packing_id' => $packing_id,
                        'SUD' => '',
                        // 'Cycle' => $num_cycle,
                        'Cycle' => $item['Cycle'],
                        'Qc_by' => $item['user_QC'],
                        'Exp_date' => $Exp_date,
                        'Create_by' => $request->cookie('Username_server_User_id'),
                        // 'Create_at' => $dateNow,
                        // 'PassStatus' => $item['check'],
                        'PassStatus' => 'true',
                        'Note' => $item['Note'],
                    ]
                );


                if ($item['packing_id'] == 'null' || $item['packing_id'] == null || $item['packing_id'] == '' || $item['packing_id'] == '-') {
                    DB::table('packing')
                        ->where('packing_id', $packing_id)
                        ->update([
                            'Create_at' => $dateNow,
                        ]);
                }


                $Item_status = DB::table('packing')
                    ->select('items.Item_status')
                    ->leftjoin('items', 'items.item_id', '=', 'packing.item_id')
                    ->where('packing.Order_id', $data['OrderId'])
                    ->where('packing.item_id', $item['item_id'])
                    ->where('packing.packing_id', $packing_id)
                    ->get();

                if ($Item_status[0]->Item_status == 'Washing Finish') {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'On sterile',
                        ]);

                    DB::table('sterile_qc')->insert([
                        'Order_id' => $data['OrderId'],
                        'item_id' => $item['item_id'],
                        'sterile_qc_id' =>  $this->AutuIDsterile(),
                        'PassStatus' => null,
                        'Create_by' => $request->cookie('Username_server_User_id'),
                        'Create_at' => $dateNow,
                        // 'Update_at' => null,
                    ]);
                }


                // if($item['check'] == 'true'){

                // }


                // if ($item['check'] == 'true' && ( $Item_status[0]->Item_status == 'Packing' || $Item_status[0]->Item_status == 'Washing Finish' )) {
                //     DB::table('items')
                //         ->where('Item_id', $item['item_id'])
                //         ->where('Order_id', $data['OrderId'])
                //         ->update([
                //             'Item_status' => 'Packing Finish',
                //         ]);
                // } elseif($item['check'] != 'true' && $Item_status[0]->Item_status == 'Washing Finish') {
                //     DB::table('items')
                //         ->where('Item_id', $item['item_id'])
                //         ->where('Order_id', $data['OrderId'])
                //         ->update([
                //             'Item_status' => 'Packing',
                //         ]);
                // }
            }

            $OnProcess_controller = new OnProcess_controller;

            $item = $OnProcess_controller->OnProcess_GetOderItem($request);
            // dd($item->items);
            $return_data->items = $item->items;
            $return_data->code = '0000';

            return $return_data;
        } catch (Exception $e) {

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_GetUserQC(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $user = DB::table('users')
                ->select('*')
                ->get();

            $return_data->code = '1000';
            $return_data->user = $user;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_GetPacking_Img_list(Request $request)
    {

        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $packing_img = DB::table('packing_img')
                ->select('*')
                ->where('packing_id', $data['packing_id'])
                ->get();

            $return_data->code = '1000';
            $return_data->packing_img = $packing_img;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '0200';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_New_ImagePacking(Request $request)
    {
        $data = $request->all();
        $return_data = new \stdClass();

        try {

            // dd($data['files']->getClientOriginalExtension());

            $image_id = $this->AutuIDImg();

            $imageName = $image_id . '.' . $data['files']->getClientOriginalExtension();
            $data['files']->move(public_path('assets/image/packing'), $imageName);
            // dd($data['packing_id']);

            DB::table('packing_img')->insert([
                'packing_id' => $data['packing_id'],
                'image_id' => $image_id,
                'image' =>  $imageName,
            ]);

            $return_data->code = '1000';
            return $return_data;
        } catch (Exception $e) {

            $return_data->code = '0200';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function OnProcess_Delete_Img_list(Request $request)
    {
        $data = $request->all();
        $return_data = new \stdClass();

        try {

            // dd($data['files']->getClientOriginalExtension());

            // $imageName = $image_id . '.' . $data['files']->getClientOriginalExtension();
            // $data['files']->move(public_path('assets/image/packing'), $imageName);
            // dd($data['packing_id']);

            if (File::exists(public_path('assets/image/packing/' . $data['image']))) {
                File::delete(public_path('assets/image/packing/' . $data['image']));
            }

            DB::table('packing_img')
                ->where('packing_id', $data['packing_id'])
                ->where('image_id', $data['image_id'])
                ->delete();

            $return_data->code = '1000';
            return $return_data;
        } catch (Exception $e) {

            $return_data->code = '0200';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function getPackingPDF(Request $request)
    {

        $data = $request->all();
        $dateNow = Carbon::now();
        $oder_id = $request->route('oder_id');
        $item_id = $request->route('item_id');
        $packing_id = $request->route('packing_id');

        // dd($oder_id);
        $items = DB::table('packing')
            ->select(
                'packing.*',
                'equipments.Name',
                'machine.Machine_name',
                'programs.Program_name',
                'machine_programs.Program_id',
                'user_QC.Name as UserName_QC',
                'items.Quantity',
                'items.Item_status',
                'items.SUD',
                'orders.Department_id',
                'departments.Department_name',
                'customers.Customer_name',
                'equipments.Process',
                'user_create.Name as UserCreate',
                'equipments.Instrument_type'
            )
            ->leftjoin('items', 'items.item_id', '=', 'packing.item_id')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->leftjoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
            ->leftjoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->leftjoin('machine', 'packing.Machine_id', '=', 'machine.Machine_id')
            // ->leftjoin('machine_programs', 'machine.Machine_id', '=', 'machine_programs.Machine_id')
            ->leftJoin('machine_programs', function ($join) {
                $join->on('machine.Machine_id', '=', 'machine_programs.Machine_id');
                $join->on('packing.Program_id', '=', 'machine_programs.Program_id');
            })
            ->leftjoin('programs', 'machine_programs.Program_id', '=', 'programs.Program_id')
            ->leftjoin('users as user_QC', 'packing.Qc_by', '=', 'user_QC.User_id')
            ->leftjoin('users as user_create', 'packing.Create_by', '=', 'user_create.User_id')
            ->where('packing.Order_id', $oder_id)
            ->where(function ($query) use ($item_id) {
                if (isset($item_id)) {
                    $query->where('items.item_id', $item_id);
                }
            })
            ->where('packing.packing_id', $packing_id)
            ->orderBy('packing_id')
            ->get();
        // dd($items);
        // dd($items->toArray());

        foreach ($items as $item) {
            // dd($item->Machine_name);
            $item->qr_code = base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate($item->item_id));
            $regular_no = preg_match('/\No[.].*$/', $item->Machine_name, $match);
            $item->txt_processNO = isset($match[0]) ? $match[0] : $item->Machine_name;
            // dd($item->Machine_name[strlen($txt_process)-1]);
            // dd($match);
        }



        $pdf = PDF::loadView('pdf.QR_Code_Packing', compact('items'));
        $customPaper = array(0, 0, 156.168, 184.2519685032);
        $pdf->setPaper($customPaper);

        return @$pdf->stream();
    }
}
