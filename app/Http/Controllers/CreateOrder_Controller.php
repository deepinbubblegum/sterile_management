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
        // $Equipments_date = DB::table('equipments')
        //     ->select('equipments.Equipment_id', 'equipments.Department_id', 'equipments.Name', 'equipments.Process', 'equipments.Price')
        //     ->where('equipments.Department_id', $recv['Department_id'])
        //     ->get();

        $Equipments_date = DB::table('dept_equip')
            ->select('dept_equip.Equipment_id', 'dept_equip.Department_id', 'equipments.Name', 'equipments.Process', 'equipments.Price')
            ->join('equipments', 'equipments.Equipment_id', '=', 'dept_equip.Equipment_id')
            ->where('dept_equip.Department_id', $recv['Department_id'])
            ->where('equipments.Activate', 'A')
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

    private function getAutoOrdersID()
    {
        $oid = DB::select(
            'SELECT CONCAT("OID-",LPAD(SUBSTRING(IFNULL(MAX(orders.Order_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM orders'
        );
        return $oid[0]->auto_id;
    }

    private function getAutoItemsID()
    {
        $itm = DB::select(
            'SELECT CONCAT("ITM-",LPAD(SUBSTRING(IFNULL(MAX(items.Item_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM items'
        );
        return $itm[0]->auto_id;
    }

    public function createOrders(Request $request)
    {
        try {
            $recv = $request->all();
            $_notes_messages = $recv['notes_messages'];
            $_cutomers_id = $recv['customers_id'];
            $_departments_id = $recv['departments_id'];
            $_items = $recv['items'];
            $order_id = $this->getAutoOrdersID();
            $user_id = $request->cookie('Username_server_User_id');

            DB::table('orders')->insert([
                'Order_id' => $order_id,
                'StatusApprove' => 0,
                'StatusOrder' => 'W',
                'Notes' => $_notes_messages,
                'Create_by' => $user_id,
                'Create_at' => Carbon::now(),
                'Customer_id' => $_cutomers_id,
                'Department_id' => $_departments_id,
            ]);
    
            foreach ($_items as $key => $value) {
                $item_id = $this->getAutoItemsID();
                DB::table('items')->insert([
                    'Item_id' => $item_id,
                    'Order_id' => $order_id,
                    'Quantity' => $value['qty'],
                    'Item_status' => '-',
                    'Equipment_id' => $value['equipment_id'],
                    'Situation_id' => $value['situation']
                ]);
            }
        } catch (\Throwable $th) {
            return json_decode(FALSE);
        }
        return json_decode(TRUE);
    }
}
