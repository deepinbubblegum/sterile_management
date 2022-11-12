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
use App\Http\Controllers\UsersPermission_Controller;

class Dashboard_Controller extends BaseController
{

    public function Get_Stock_Exp(Request $request)
    {

        $dateNow = Carbon::now();
        $req = $request->all();

        $month = $req['month'];
        $year = $dateNow->year;

        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();

        $dep_id = null;
        if ($permissions->{'Dashboard Admin'} == '0') {
            $departments = DB::table('usersdepartments')
                ->select('*')
                ->where('User_id', Cookie::get('Username_server_User_id'))
                ->get();
            // dd($departments);
            $dep_id = $departments[0]->Department_id;
        }

        // stock_exp
        $stock_exp = DB::table('stock')
            ->select('stock.*', 'packing.Exp_date', 'equipments.Name')
            ->leftjoin('packing', 'stock.item_id', '=', 'packing.item_id')
            ->leftjoin('orders', 'stock.Order_id', '=', 'orders.Order_id')
            ->leftjoin('items', 'stock.item_id', '=', 'items.item_id')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->where(function ($query) use ($dep_id) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }
            })
            ->paginate(15);

        return $stock_exp;
    }

    public function Get_Data(Request $request)
    {

        $dateNow = Carbon::now();
        $req = $request->all();

        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();

        $dep_id = null;
        if ($permissions->{'Dashboard Admin'} == '0') {
            $departments = DB::table('usersdepartments')
                ->select('*')
                ->where('User_id', Cookie::get('Username_server_User_id'))
                ->get();
            // dd($departments);
            $dep_id = $departments[0]->Department_id;
        }

        $month = $req['month'];
        $year = $dateNow->year;
        // dd($month);

        $departments = DB::table('departments')
            ->select('*')
            ->count();

        $customers = DB::table('customers')
            ->select('*')
            ->count();

        $item_month = DB::table('items')
            ->selectRaw('sum(items.Quantity) as sum')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->where(function ($query) use ($dep_id) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }
            })
            ->first()->sum;

        $item_year = DB::table('items')
            ->selectRaw('sum(items.Quantity) as sum')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->where(function ($query) use ($dep_id) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }
            })
            ->first()->sum;

        // dd($item_month);

        if ($permissions->{'Dashboard Admin'} == '1') {
            $type_sterile = DB::select('
            SELECT MAX(CASE WHEN ST.Situation_id = "STT-0001" THEN ST.sum_item ELSE 0 END) AS "Sterlie",
                    MAX(CASE WHEN ST.Situation_id = "STT-0002" THEN ST.sum_item ELSE 0 END) AS "Re-Sterlie",
                    MAX(CASE WHEN ST.Situation_id = "STT-0003" THEN ST.sum_item ELSE 0 END) AS "Claim",
                    MAX(CASE WHEN ST.Situation_id = "STT-0004" THEN ST.sum_item ELSE 0 END) AS "Borrow",
                    MAX(CASE WHEN ST.Situation_id = "STT-0005" THEN ST.sum_item ELSE 0 END) AS "Damage",
                    MAX(CASE WHEN ST.Situation_id = "STT-0006" THEN ST.sum_item ELSE 0 END) AS "Loss"
            FROM (
                SELECT Situation_id, sum(Quantity) as sum_item
                FROM items
                LEFT JOIN orders ON orders.Order_id = items.Order_id
                WHERE YEAR(orders.Create_at) = "' . $year . '"
                AND MONTH(orders.Create_at) = "' . $month . '"
                GROUP BY Situation_id
            ) ST
            ')[0];
        } else {

            $type_sterile = DB::select('
            SELECT MAX(CASE WHEN ST.Situation_id = "STT-0001" THEN ST.sum_item ELSE 0 END) AS "Sterlie",
                    MAX(CASE WHEN ST.Situation_id = "STT-0002" THEN ST.sum_item ELSE 0 END) AS "Re-Sterlie",
                    MAX(CASE WHEN ST.Situation_id = "STT-0003" THEN ST.sum_item ELSE 0 END) AS "Claim",
                    MAX(CASE WHEN ST.Situation_id = "STT-0004" THEN ST.sum_item ELSE 0 END) AS "Borrow",
                    MAX(CASE WHEN ST.Situation_id = "STT-0005" THEN ST.sum_item ELSE 0 END) AS "Damage",
                    MAX(CASE WHEN ST.Situation_id = "STT-0006" THEN ST.sum_item ELSE 0 END) AS "Loss"
            FROM (
                SELECT Situation_id, sum(Quantity) as sum_item
                FROM items
                LEFT JOIN orders ON orders.Order_id = items.Order_id
                WHERE YEAR(orders.Create_at) = "' . $year . '"
                AND MONTH(orders.Create_at) = "' . $month . '"
                AND orders.Department_id = "' . $dep_id . '"
                GROUP BY Situation_id
            ) ST
            ')[0];
        }
        // dd($type_sterile);

        $month_list_item = DB::select('SELECT SUM(CASE WHEN MONTH(Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM items
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
        ')[0];


        $month_Claim = DB::select('SELECT SUM(CASE WHEN MONTH(Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM items
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
            AND items.Situation_id = "STT-0003"
        ')[0];


        $month_loss = DB::select('SELECT SUM(CASE WHEN MONTH(Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM items
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
            AND items.Situation_id = "STT-0006"
        ')[0];


        $month_Damage = DB::select('SELECT SUM(CASE WHEN MONTH(Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM items
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
            AND items.Situation_id = "STT-0005"
        ')[0];

        // วงกลม ค้างส่ง
        // $backlog_item = DB::table('items')
        //     ->selectRaw('Department_id, count(items.Item_id)')
        //     ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
        //     ->where('Item_status', '!=', 'Deliver')
        //     ->groupBy('Department_id')
        //     ->get();

        $backlog_item = DB::table('items')
            ->selectRaw('count(items.Item_id) As item')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->where('Item_status', '!=', 'Deliver')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->where(function ($query) use ($dep_id) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }
            })
            ->get();

        $all_item = DB::table('items')
            ->selectRaw('count(items.Item_id) As item')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->where(function ($query) use ($dep_id) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }
            })
            ->get();

        $backlog = new \stdClass();
        $backlog->all = $all_item[0]->item;
        $backlog->backlog = $backlog_item[0]->item;
        // $backlog = (['all' => $all_item[0]->item, 'backlog'  => $backlog_item[0]->item]);

        // Check SUD
        $SUD_all_item = DB::table('equipments')
            ->select('*')
            ->count();

        $SUD_item = DB::table('equipments')
            ->select('*')
            ->where('SUD', '1')
            ->count();

        $SUD = new \stdClass();
        $SUD->all = $SUD_all_item;
        $SUD->sud = $SUD_item;

        // Check SUD Per Month
        $SUD_Month_all_item = DB::table('items')
            ->select('*')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->count();

        $SUD_Month_item = DB::table('items')
            ->select('*')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->where('equipments.SUD', '1')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->count();

        $SUD_Month = new \stdClass();
        $SUD_Month->all = $SUD_Month_all_item;
        $SUD_Month->sud = $SUD_Month_item;



        // Sterile Fail
        $Sterile_all = DB::select('SELECT SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM sterile_qc
            LEFT JOIN orders ON orders.Order_id = sterile_qc.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"')[0];

        $Sterile_fail = DB::select('SELECT SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(sterile_qc.Create_at) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM sterile_qc
            LEFT JOIN orders ON orders.Order_id = sterile_qc.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
            AND PassStatus ="false" ')[0];

        $Sterile_Fail = new \stdClass();
        $Sterile_Fail->all = $Sterile_all;
        $Sterile_Fail->fail = $Sterile_fail;


        $deliver = DB::select('SELECT SUM(CASE WHEN MONTH(date_in_stock) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(date_in_stock) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(date_in_stock) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(date_in_stock) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(date_in_stock) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(date_in_stock) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(date_in_stock) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(date_in_stock) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(date_in_stock) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(date_in_stock) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(date_in_stock) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(date_in_stock) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM stock
            WHERE YEAR(date_in_stock) ="2022"')[0];

        $deliver_late = DB::select('SELECT SUM(CASE WHEN MONTH(date_in_stock) = "01" THEN 1 ELSE 0 END) AS "1",
                SUM(CASE WHEN MONTH(date_in_stock) = "02" THEN 1 ELSE 0 END) AS "2",
                SUM(CASE WHEN MONTH(date_in_stock) = "03" THEN 1 ELSE 0 END) AS "3",
                SUM(CASE WHEN MONTH(date_in_stock) = "04" THEN 1 ELSE 0 END) AS "4",
                SUM(CASE WHEN MONTH(date_in_stock) = "05" THEN 1 ELSE 0 END) AS "5",
                SUM(CASE WHEN MONTH(date_in_stock) = "06" THEN 1 ELSE 0 END) AS "6",
                SUM(CASE WHEN MONTH(date_in_stock) = "07" THEN 1 ELSE 0 END) AS "7",
                SUM(CASE WHEN MONTH(date_in_stock) = "08" THEN 1 ELSE 0 END) AS "8",
                SUM(CASE WHEN MONTH(date_in_stock) = "09" THEN 1 ELSE 0 END) AS "9",
                SUM(CASE WHEN MONTH(date_in_stock) = "10" THEN 1 ELSE 0 END) AS "10",
                SUM(CASE WHEN MONTH(date_in_stock) = "11" THEN 1 ELSE 0 END) AS "11",
                SUM(CASE WHEN MONTH(date_in_stock) = "12" THEN 1 ELSE 0 END) AS "12"
            FROM stock
            WHERE YEAR(date_in_stock) ="2022"
            and DATE_FORMAT(date_in_stock + INTERVAL 2 DAY, "%d/%m/%Y , %h:%m:%s") < DATE_FORMAT(date_out_stock, "%d/%m/%Y , %h:%m:%s")')[0];

        // dd($stock_exp);

        $List_Deliver_late = new \stdClass();
        $List_Deliver_late->all = $deliver;
        $List_Deliver_late->late = $deliver_late;


        $List = new \stdClass();
        $List->departments = $departments;
        $List->customers = $customers;
        $List->month_list_item = $month_list_item;
        $List->item_month = $item_month;
        $List->item_year = $item_year;
        $List->type_sterile = $type_sterile;
        $List->backlog_item = $backlog;
        $List->departments = $departments;
        $List->month_Claim = $month_Claim;
        $List->month_loss = $month_loss;
        $List->month_Damage = $month_Damage;
        $List->SUD = $SUD;
        $List->SUD_Month = $SUD_Month;
        $List->Sterile_Fail = $Sterile_Fail;
        $List->deliver_late = $List_Deliver_late;
        return $List;
    }
}