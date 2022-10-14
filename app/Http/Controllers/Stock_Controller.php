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

class Stock_Controller extends BaseController
{
    public function Get_Stock(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $items = DB::table('orders')
                ->select('orders.*',  'userCreate.Username as userCreate', 'userUpdate.Username as userUpdate',  'userApprove.Username as userApprove')
                ->leftjoin('users AS userCreate', 'orders.Create_by', '=', 'userCreate.user_id')
                ->leftjoin('users AS userUpdate', 'orders.Update_by', '=', 'userUpdate.user_id')
                ->leftjoin('users AS userApprove', 'orders.Approve_by', '=', 'userApprove.user_id')
                ->leftjoin('stock', 'orders.order_id', '=', 'stock.order_id')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('order_id', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->where('orders.StatusOrder', 'Stock')
                ->orderBy('orders.order_id', 'DESC')
                ->orderBy('Stock_id', 'DESC')
                ->distinct('orders.order_id')
                // ->get()
                ->paginate(5);

            $return_data->code = '1000';
            $return_data->orders = $items;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

}
