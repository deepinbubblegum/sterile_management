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

class Scan_QR_Code extends BaseController
{
    public function Get_order(Request $request)
    {
        $return_data = new \stdClass();
        $data = $request->all();

        try {

            $orders = DB::table('orders')
                ->select('*')
                // ->where('Item_status', 'Stock')
                ->where('Order_id', $data['order_id'])
                ->first();

            // $array = (array) $list_Stock;

            $return_data->code = '0000';
            $return_data->orders = $orders;

            return $return_data;
        } catch (Exception $e) {

            $return_data->code = '2000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }
}