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

class CreateOrder_Controller extends BaseController
{
    public function getCustomers(Request $request)
    {
        $Customers_data = DB::table('customers')
            ->select('customers.Customer_id', 'customers.Customer_name')
            ->get();

        return $Customers_data;
    }

    public function getDepartments(Request $request)
    {
        $recv = $request->all();
        // dd($recv);
        $Department_data = DB::table('departments')
            ->select('departments.Department_id', 'departments.Department_name')
            ->where('departments.Customer_id', $recv['Customer_id'])
            ->get();
        return $Department_data;
    }

    public function getEquipments(Request $request)
    {
        $recv = $request->all();
        $Equipments_date = DB::table('equipments')
            ->select('equipments.Equipment_id', 'equipments.Department_id', 'equipments.Name', 'equipments.Process', 'equipments.Price')
            ->where('equipments.Department_id', $recv['Department_id'])
            ->get();
        return $Equipments_date;
    }

    public function getSituations()
    {
        $Situations_data = DB::table('situations')
            ->select('situations.Situation_id', 'situations.Situation_name')
            ->get();
        return $Situations_data;
    }

    public function createOders(Request $request)
    {
        $recv = $request->all();
        dd($recv);
    }
}
