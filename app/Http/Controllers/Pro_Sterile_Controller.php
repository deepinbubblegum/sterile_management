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

class Pro_Sterile_Controller extends BaseController
{


    private function AutuIDStock()
    {
        $oid = DB::select(
            'SELECT CONCAT("STK-",LPAD(SUBSTRING(IFNULL(MAX(stock.Stock_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM stock'
        );
        return $oid[0]->auto_id;
    }


    public function OnProcess_Getsterile_List(Request $request)
    {

        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('sterile_qc')
                ->select('sterile_qc.*', 'equipments.Name', 'machine.Machine_name', 'machine_programs.Program_name', 'machine_programs.Program_id', 'users.Name as UserName_QC', 'items.Quantity', 'items.Item_status', 'packing.Exp_date', 'packing.Cycle')
                ->leftjoin('packing', 'sterile_qc.item_id', '=', 'packing.item_id')
                ->leftjoin('items', 'items.item_id', '=', 'packing.item_id')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('machine', 'packing.Machine_id', '=', 'machine.Machine_id')
                ->leftjoin('machine_programs', 'machine.Machine_id', '=', 'machine_programs.Machine_id')
                ->leftjoin('users', 'packing.Qc_by', '=', 'users.User_id')
                ->where('sterile_qc.Order_id', $data['OrderId'])
                ->orderBy('sterile_qc_id')
                ->get();

            $return_data->code = '0000';
            $return_data->sterile_List = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function OnProcess_New_sterileList(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $dateNow = Carbon::now();

            foreach ($data['sterileItem'] as $item) {

                $Item_status = DB::table('sterile_qc')
                    ->select('items.Item_status')
                    ->leftjoin('items', 'items.item_id', '=', 'sterile_qc.item_id')
                    ->where('sterile_qc.Order_id', $data['OrderId'])
                    ->where('sterile_qc.item_id', $item['item_id'])
                    ->get();

                // dd($Item_status);

                if ($Item_status[0]->Item_status == 'On sterile') {
                    DB::table('items')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->update([
                            'Item_status' => 'Stock',
                        ]);


                    DB::table('sterile_qc')
                        ->where('Item_id', $item['item_id'])
                        ->where('Order_id', $data['OrderId'])
                        ->where('sterile_qc_id', $item['sterile_qc_id'])
                        ->update([
                            'PassStatus' => 'true',
                            'Update_by' => $request->cookie('Username_server_User_id'),
                            'Update_at' => $dateNow

                        ]);

                    DB::table('stock')->insert([
                        'Stock_id' => $this->AutuIDStock(),
                        'Order_id' => $data['OrderId'],
                        'item_id' => $item['item_id'],
                        'date_in_stock' => $dateNow,
                        'date_out_stock' => null,
                        'PDF' => null,
                        'Signature_custumer' => null,
                    ]);
                }
            }

            $return_data->code = '0000';

            return $return_data;

        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }
}