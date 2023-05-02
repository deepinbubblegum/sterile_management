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
use Illuminate\Support\Facades\Hash;

class OnProcess_controller extends BaseController
{
    public function OnProcess_GetOderItem(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('items')
                ->select('items.*', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'equipments.Item_Type', 'equipments.Expire', 'equipments.Instrument_type', 'situations.Situation_name', 'equipments.Item_Type')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
                // ->leftjoin('washing', 'items.item_id', '=', 'washing.item_id')
                ->where('items.Order_id', $data['OrderId'])
                // ->orderBy('items.item_id')
                ->distinct()
                ->orderByRaw('LENGTH(items.item_id)')
                ->get();

            foreach ($items as $val) {
                $wh = DB::table('washing')
                    ->select('washing.*')
                    ->where('item_id', $val->Item_id)
                    ->where('Order_id', $data['OrderId'])
                    // ->where(function($query) {
                    //     $query->whereNull('PassStatus');
                    //     $query->where('PassStatus' , '!=' , 'Pass');
                    // })
                    ->orderBy('washing_id')
                    ->get();

                if (count($wh) == 0) {
                    $val->washing_stete = null;
                } else {
                    $whnull = DB::table('washing')
                        ->select('washing.*')
                        ->where('item_id', $val->Item_id)
                        ->where('Order_id', $data['OrderId'])
                        ->where(function ($query) {
                            $query->whereNull('PassStatus');
                            $query->orWhere('PassStatus', '=', 'Pass');
                        })
                        ->orderBy('washing_id')
                        ->get();

                    if( count($whnull) == 0 ){
                        $val->washing_stete = null;
                    }else{
                        $val->washing_stete = 'list';
                    }
                }
                // $items->washing_stete = ''
            }

            $return_data->code = '1000';
            $return_data->items = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }


    public function myfilter($row)
    {
        return ($row['PassStatus'] == null || $row['type'] == 'education');
    }


    // public function OnProcess_GetWashing_machine(Request $request)
    // {
    //     try {

    //         $return_data = new \stdClass();
    //         $data = $request->all();

    //         $items = DB::table('machineswashing')
    //             ->select('*')
    //             ->get();

    //         $return_data->machineswashing = $items;

    //         return $return_data;
    //     } catch (Exception $e) {

    //         $return_data = new \stdClass();

    //         $return_data->code = '000000';
    //         $return_data->message =  $e->getMessage();

    //         return $return_data;
    //     }
    // }


    // public function OnProcess_GetWashing_List(Request $request)
    // {
    //     try {

    //         $return_data = new \stdClass();
    //         $data = $request->all();

    //         $items = DB::table('washing')
    //             ->select('*')
    //             ->where('Order_id', $data['OrderId'])
    //             ->get();

    //         $return_data->washing_List = $items;

    //         return $return_data;
    //     } catch (Exception $e) {

    //         $return_data = new \stdClass();

    //         $return_data->code = '000000';
    //         $return_data->message =  $e->getMessage();

    //         return $return_data;
    //     }
    // }

    // public function Washing_newItem(Request $request)
    // {

    //     $return_data = new \stdClass();

    //     try {

    //         $data = $request->all();

    //         DB::table('table name')
    //             ->updateOrInsert(
    //                 [
    //                     'email' => 'admin@admin.com',
    //                     'name' => 'Admin'
    //                 ],
    //                 ['id' => '7']
    //             );

    //     } catch (Exception $e) {

    //         $return_data->code = '000000';
    //         $return_data->message =  $e->getMessage();

    //         return $return_data;
    //     }
    // }
}
