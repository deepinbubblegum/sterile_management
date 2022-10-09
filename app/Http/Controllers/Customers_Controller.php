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

class Customers_Controller extends BaseController
{
    public function getListCustomers(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();

            $customers = DB::table('customers')
                ->select('customers.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('Customer_name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('Customer_id', 'desc')
                ->paginate(8);
            $return_data->customers = $customers;
            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }
}
