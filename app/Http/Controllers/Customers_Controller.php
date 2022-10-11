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

    private function getAutoCustomersID()
    {
        $oid = DB::select(
            'SELECT CONCAT("CTM-",LPAD(SUBSTRING(IFNULL(MAX(customers.Customer_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM customers'
        );
        return $oid[0]->auto_id;
    }

    public function createCustomers(Request $request)
    {
        $recv = $request->all();
        $customer_name = $recv['customer_name'];
        $address = $recv['address'];
        $id_customer = $this->getAutoCustomersID();
        DB::table('customers')->insert([
            'Customer_id' => $id_customer,
            'Customer_name' => $customer_name,
            'address' => $address
        ]);
        return json_encode(TRUE);
    }

    public function deleteCustomers(Request $request)
    {
        $recv = $request->all();
        $customer_id = $recv['customer_id'];
        DB::table('customers')->where('Customer_id', $customer_id)->delete();
        return json_encode(TRUE);
    }

    public function getCustomersDetail(Request $request)
    {
        $recv = $request->all();
        $customer_id = $recv['customer_id'];
        $customer = DB::table('customers')->where('Customer_id', $customer_id)->first();
        return json_encode($customer);
    }

    public function updateCustomers(Request $request)
    {
        $recv = $request->all();
        $customer_id = $recv['customer_id'];
        $customer_name = $recv['customer_name'];
        $address = $recv['customer_address'];
        DB::table('customers')->where('Customer_id', $customer_id)->update([
            'Customer_name' => $customer_name,
            'address' => $address
        ]);
        return json_encode(TRUE);
    }
}
