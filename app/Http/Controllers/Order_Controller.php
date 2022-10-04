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
use PDF;
use QrCode;

class Order_Controller extends BaseController
{
    public function getListOrder(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();

            $users = DB::table('orders')
                ->select('orders.*',  'userCreate.Username as userCreate', 'userUpdate.Username as userUpdate',  'userApprove.Username as userApprove', 'customers.Customer_name', 'departments.Department_name')
                ->leftjoin('users AS userCreate', 'orders.Create_by', '=', 'userCreate.user_id')
                ->leftjoin('users AS userUpdate', 'orders.Update_by', '=', 'userUpdate.user_id')
                ->leftjoin('users AS userApprove', 'orders.Approve_by', '=', 'userApprove.user_id')
                ->leftjoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
                ->leftjoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('order_id', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('order_id', 'desc')
                ->paginate(8);

            $return_data->orders = $users;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function delOrder(Request $request)
    {
        $recv = $request->all();
        $id = $recv['id'];
        DB::table('orders')->where('Order_id', $id)->delete();
        return json_encode(true);
    }

    // function gen order pdf
    public function getOrderPDF(Request $request)
    {
        $recv = $request->all();
        $id = $recv['orderid'];

        $data = [
            'qrcode_order' => base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate('string')),
        ];

          
        $pdf = PDF::loadView('pdf.order', $data);
        $pdf->setPaper('A4');
    
        return @$pdf->stream();
    }
}
