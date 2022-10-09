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


    public function OnProcess_GetSterlie_machine(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items_machine = DB::table('machine')
                ->select('machine.*')
                ->get();

            $items_program = DB::table('machine_programs')
                ->select('machine_programs.*')
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
                ->select('packing.*', 'equipments.Name', 'machine.Machine_name' , 'machine_programs.Program_name' , 'machine_programs.Program_id' , 'users.Name as UserName_QC' , 'items.Quantity', 'items.Item_status')
                ->leftjoin('items', 'items.item_id', '=', 'packing.item_id')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('machine', 'packing.Machine_id', '=', 'machine.Machine_id')
                ->leftjoin('machine_programs', 'machine.Machine_id', '=', 'machine_programs.Machine_id')
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

            $Cycle_Customer = DB::table('packing')
                ->selectRaw('max(Cycle) as maxCycle')
                ->leftjoin('orders', 'packing.Order_id', '=', 'orders.Order_id')
                ->where('orders.Customer_id', $CUS_ID[0]->Customer_id)
                ->get();
            // dd($Cycle_Customer[0]->maxCycle);

            $index = (int)$Cycle_Customer[0]->maxCycle;
            // $mach_cycle = array();
            $new_mach_cycle = collect([]);
            $Cycle_ma = $this->unique_multidim_array($data['PackingItem'], 'Machines_id');
            foreach ($Cycle_ma as $item_Cycle) {
                // $item_Cycle->name = "My name";
                $index++;
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
                    $Exp_date =Carbon::now()->addDay($item['AddExp']);
                }
                // dd($dateNow);

                $num_cycle = 0;
                if ($item['Cycle'] == null || $item['Cycle'] == 'null' || $item['Cycle'] == '') {

                    $num_cycle = $new_mach_cycle->where('Machines_id', '==', $item['Machines_id'])->values()[0]['cycle'];
                } else {

                    $num_cycle = $item['Cycle'];
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
                        'Cycle' => $num_cycle,
                        'Qc_by' => $item['user_QC'],
                        'Exp_date' => $Exp_date,
                        'Create_by' => $request->cookie('Username_server_User_id'),
                        'Create_at' => $dateNow,

                    ]
                );

                if ($item['check'] == 'true') {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'Packing Finish',
                        ]);
                } else {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'Packing',
                        ]);
                }
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

    // public function OnProcess_New_PackingList(Request $request){

    // }
}
