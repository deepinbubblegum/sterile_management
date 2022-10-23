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

class StockList_Controller extends BaseController
{
    public function Get_StockList_Item(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('items')
                ->select('items.*', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'equipments.Item_Type', 'equipments.Expire', 'equipments.Instrument_type', 'situations.Situation_name', 'washing.washing_id', 'equipments.Item_Type')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
                ->leftjoin('washing', 'items.item_id', '=', 'washing.item_id')
                ->where('items.Order_id', $data['OrderId'])
                // ->where('items.Item_status', 'Stock')
                // ->where('washing.PassStatus', 'Pass')
                // ->orderBy('items.item_id')
                ->groupBy('items.item_id')
                ->orderByRaw('LENGTH(items.item_id)')
                ->get();

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
}
