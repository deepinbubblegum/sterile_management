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

class DeptEquip_Controller extends BaseController
{
    public function viewDeptEquip(Request $request, $id)
    {
        $customer_id = $request->customer_id;
        return view('deptequip', ['customer_id' => $customer_id]);
    }

    public function getListDeptEquip(Request $request)
    {
        try {
            $customer_id = strtoupper($request->customer_id);
            $department_id = strtoupper($request->department_id);
            $return_data = new \stdClass();
            $data = $request->all();

            $deptequip = DB::table('dept_equip')
                ->select(
                    'dept_equip.Equipment_id', 'dept_equip.Department_id', 
                    'customers.Customer_id', 'customers.Customer_name', 'equipments.Item_Type',
                    'equipments.Name', 'equipments.Descriptions', 'equipments.Process',
                    'departments.Department_name'
                )
                ->leftjoin('departments', 'dept_equip.Department_id', '=', 'departments.Department_id')
                ->leftjoin('customers', 'departments.Customer_id', '=', 'customers.Customer_id')
                ->leftjoin('equipments', 'dept_equip.Equipment_id', '=', 'equipments.Equipment_id')
                ->where('customers.Customer_id', $customer_id)
                ->where('departments.Department_id', $department_id)
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('equipments.Name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->paginate(8);
            $return_data->deptequip = $deptequip;
            return $return_data;

        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function deleteDeptEquip(Request $request)
    {
        $recv = $request->all();
        $equipment_id = $recv['equipment_id'];
        $department_id = $recv['department_id'];
        DB::table('dept_equip')
            ->where('Equipment_id', $equipment_id)
            ->where('Department_id', $department_id)
            ->delete();
        return json_encode(TRUE);
    }

    public function getlistequip(Request $request)
    {
        $department_id = strtoupper($request->department_id);
        $equipments = DB::table('equipments')
            ->select('equipments.Equipment_id', 'equipments.Name')
            ->whereNotIn('equipments.Equipment_id',(function ($query) use ($department_id) {
                $query->from('dept_equip')
                    ->select('dept_equip.Equipment_id')
                    ->where('dept_equip.Department_id', $department_id);
            }))
            ->get();
        return $equipments;
    }

    public function addDeptEquip(Request $request)
    {
        $recv = $request->all();
        $equipment_id = $recv['equipment_id'];
        $department_id = strtoupper($request->department_id);
        DB::table('dept_equip')->insert(
            ['Equipment_id' => $equipment_id, 'Department_id' => $department_id]
        );
        return json_encode(TRUE);
    }
}
