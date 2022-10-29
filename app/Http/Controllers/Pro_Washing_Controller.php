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
use Illuminate\Support\Facades\File;

use App\Http\Controllers\OnProcess_controller;

class Pro_Washing_Controller extends BaseController
{

    private function AutuIDWashing()
    {
        $oid = DB::select(
            'SELECT CONCAT("WAS-",LPAD(SUBSTRING(IFNULL(MAX(washing.washing_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM washing'
        );
        return $oid[0]->auto_id;
    }


    public function OnProcess_GetWashing_machine(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('machineswashing')
                ->select('machineswashing.*')
                ->where('Active', '1')
                ->get();

            $return_data->code = '0000';
            $return_data->machineswashing = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function OnProcess_GetWashing_List(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('washing')
                ->select('washing.*', 'equipments.Name', 'machineswashing.MachinesWashingName', 'items.Item_status', 'items.SUD')
                ->leftjoin('items', 'items.item_id', '=', 'washing.item_id')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('machineswashing', 'machineswashing.MachinesWashing_id', '=', 'washing.MachinesWashing_id')
                ->where('washing.Order_id', $data['OrderId'])
                ->orderBy('washing_id')
                ->get();

            $return_data->code = '0000';
            $return_data->washing_List = $items;

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


    public function OnProcess_Washing_newItem(Request $request)
    {

        $return_data = new \stdClass();

        try {

            $data = $request->all();
            $dateNow = Carbon::now();

            // dd($data['WashingItem']);
            // $cycle = array_unique();

            $CUS_ID = DB::table('orders')
                ->select('orders.*')
                ->where('Order_id', $data['OrderId'])
                ->get();
            // dd($CUS_ID[0]->Customer_id);

            // $Cycle_Customer = DB::table('washing')
            //     ->selectRaw('max(Cycle) as maxCycle')
            //     ->leftjoin('orders', 'washing.Order_id', '=', 'orders.Order_id')
            //     ->where('orders.Customer_id', $CUS_ID[0]->Customer_id)
            //     // ->whereMonth('washing.Create_at', '=', now()->month)
            //     ->whereDate('washing.Create_at', Carbon::today())
            //     ->get();
            // dd($Cycle_Customer[0]->maxCycle);

            // $index = (int)$Cycle_Customer[0]->maxCycle;
            $new_mach_cycle = collect([]);
            $Cycle_ma = $this->unique_multidim_array($data['WashingItem'], 'Machines_id');

            foreach ($Cycle_ma as $item_Cycle) {

                $Cycle_Customer = DB::table('washing')
                    ->selectRaw('max(Cycle) as maxCycle')
                    ->leftjoin('orders', 'washing.Order_id', '=', 'orders.Order_id')
                    ->where('orders.Customer_id', $CUS_ID[0]->Customer_id)
                    ->where('MachinesWashing_id', $item_Cycle['Machines_id'])
                    ->whereDate('washing.Create_at', Carbon::today())
                    ->get();

                $index = (int)($Cycle_Customer[0]->maxCycle) + 1;

                $new_mach_cycle->push([
                    'Machines_id' => $item_Cycle['Machines_id'],
                    'cycle' => $index
                ]);
            }
            // dd($new_mach_cycle);

            $check_Order = DB::table('orders')
                ->select('StatusOrder')
                ->where('Order_id', $data['OrderId'])
                ->get();


            if ($check_Order[0]->StatusOrder == '' || $check_Order[0]->StatusOrder == null || $check_Order[0]->StatusOrder == '-') {
                DB::table('orders')
                    ->where('Order_id', $data['OrderId'])
                    ->update([
                        'StatusOrder' => 'On Process',
                    ]);
            }


            foreach ($data['WashingItem'] as $item) {

                $washing_id = $item['washing_id'];


                if ($washing_id == 'null' || $washing_id == null || $washing_id == '' || $washing_id == '-') {
                    $washing_id = $this->AutuIDWashing();
                }
                // dd($washing_id);

                $num_cycle = $item['Cycle'];
                if ($item['Cycle'] == null || $item['Cycle'] == 'null' || $item['Cycle'] == '') {

                    $num_cycle = $new_mach_cycle->where('Machines_id', '==', $item['Machines_id'])->values()[0]['cycle'];
                }
                // dd($item['Cycle']);

                DB::table('washing')->updateOrInsert(
                    [
                        'washing_id' => $washing_id,
                        'Order_id' => $data['OrderId'],
                        'item_id' => $item['item_id'],
                    ],
                    [
                        'washing_id' => $washing_id,
                        'Order_id' => $data['OrderId'],
                        'item_id' => $item['item_id'],
                        'MachinesWashing_id' => $item['Machines_id'],
                        'Cycle' => $item['Cycle'],
                        'QTY' => $item['QTY'],
                        'PassStatus' => $item['status'] == 'null' ? null : $item['status'],
                        // 'Create_at' => $dateNow,
                    ]
                );


                if ($item['washing_id'] == 'null' || $item['washing_id'] == null || $item['washing_id'] == '' || $item['washing_id'] == '-') {
                    DB::table('washing')
                        ->where('washing_id', $washing_id)
                        ->update([
                            'Create_at' => $dateNow,
                        ]);
                }


                $Item_status = DB::table('washing')
                    ->select('items.Item_status')
                    ->leftjoin('items', 'items.item_id', '=', 'washing.item_id')
                    ->where('washing.Order_id', $data['OrderId'])
                    ->where('washing.item_id', $item['item_id'])
                    ->where('washing.washing_id', $washing_id)
                    ->get();

                if ($item['status'] == 'Pass' && $Item_status[0]->Item_status == 'Washing') {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'Washing Finish',
                        ]);
                } else if ($item['status'] == 'Fail' && $Item_status[0]->Item_status == 'Washing') {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => null,
                            'SUD' => null,
                        ]);
                } else if (($item['status'] == null || $item['status'] == '') && ($Item_status[0]->Item_status == null)) {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'Washing',
                            'SUD' => $item['SUD'],
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



    public function OnProcess_GetWashing_Img_list(Request $request)
    {

        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $washing_img = DB::table('washing_image')
                ->select('*')
                ->where('washing_id', $data['washing_id'])
                ->get();

            $return_data->code = '1000';
            $return_data->washing_img = $washing_img;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '0200';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }



    private function AutuIDImg_Washing()
    {
        $oid = DB::select(
            'SELECT CONCAT("IMG_WAS-",LPAD(SUBSTRING(IFNULL(MAX(washing_image.image_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM washing_image'
        );
        return $oid[0]->auto_id;
    }



    public function OnProcess_New_ImageWashing(Request $request)
    {

        $data = $request->all();
        $return_data = new \stdClass();

        try {

            // dd($data['files']->getClientOriginalExtension());

            $image_id = $this->AutuIDImg_Washing();

            $imageName = $image_id . '.' . $data['files']->getClientOriginalExtension();
            $data['files']->move(public_path('assets/image/washing'), $imageName);
            // dd($data['packing_id']);

            DB::table('washing_image')->insert([
                'washing_id' => $data['washing_id'],
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


    public function OnProcess_Delete_Img_Washing_list(Request $request)
    {
        $data = $request->all();
        $return_data = new \stdClass();

        try {

            if (File::exists(public_path('assets/image/washing/' . $data['image']))) {
                File::delete(public_path('assets/image/washing/' . $data['image']));
            }

            DB::table('washing_image')
                ->where('washing_id', $data['washing_id'])
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
}
