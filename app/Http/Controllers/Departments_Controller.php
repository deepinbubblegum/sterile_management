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

class Departments_Controller extends BaseController
{
    public function departmentsView(Request $request, $id)
    {
        $customer_id = $request->customer_id;
        return view('departments', ['customer_id' => $customer_id]);
    }

    public function getListDepartments(Request $request, $id)
    {
        try {
            $customer_id = $request->customer_id;
            $recv = $request->all();
            $return_data = new \stdClass();
    
            $departments = DB::table('departments')
                ->select('departments.Department_id', 'departments.Customer_id', 'departments.Department_name', 'customers.Customer_name')
                ->leftjoin('customers', 'departments.Customer_id', '=', 'customers.Customer_id')
                ->where('customers.Customer_id', strtoupper($customer_id))
                ->where(function ($query) use ($recv) {
                    if ($recv['txt_search'] != '') {
                        $query->where('Department_name', 'like', '%' . $recv['txt_search'] . '%');
                    }
                })
                ->orderBy('Department_id', 'desc')
                ->paginate(8);
            $return_data->departments = $departments;
            return $return_data;

        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    private function getAutoDepartmentID()
    {
        $dept = DB::select(
            'SELECT CONCAT("DPM-",LPAD(SUBSTRING(IFNULL(MAX(departments.Department_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM departments'
        );
        return $dept[0]->auto_id;
    }

    public function createDepartments(Request $request, $id)
    {
        $customer_id = $request->customer_id;
        $recv = $request->all();
        $department_name = $recv['department_name'];
        DB::table('departments')->insert([
            'Department_id' => $this->getAutoDepartmentID(),
            'Department_name' => $department_name,
            'Customer_id' => strtoupper($customer_id),
        ]);

        return json_encode(TRUE);
    }
    
    public function deleteDepartments(Request $request, $id)
    {
        $customer_id = strtoupper($request->customer_id);
        $recv = $request->all();
        $department_id = $recv['department_id'];
        DB::table('departments')
            ->where('Department_id', $department_id)
            ->delete();
        return json_encode(TRUE);
    }

    public function getDepartmentsDetail(Request $request, $id)
    {
        $customer_id = strtoupper($request->customer_id);
        $recv = $request->all();
        $department_id = $recv['department_id'];
        $department = DB::table('departments')
            ->select('departments.Department_id', 'departments.Customer_id', 'departments.Department_name', 'customers.Customer_name')
            ->leftjoin('customers', 'departments.Customer_id', '=', 'customers.Customer_id')
            ->where('departments.Department_id', $department_id)
            ->first();
        return json_encode($department);
    }

    public function updateDepartments(Request $request, $id)
    {
        $customer_id = strtoupper($request->customer_id);
        $recv = $request->all();
        $department_id = $recv['department_id'];
        $department_name = $recv['department_name'];
        DB::table('departments')
            ->where('Department_id', $department_id)
            ->update([
                'Department_name' => $department_name,
            ]);
        return json_encode(TRUE);
    }
}
