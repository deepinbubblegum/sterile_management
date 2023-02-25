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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Dashboard_Controller extends BaseController
{

    public function Get_Department()
    {
        $departments = DB::table('departments')
            ->select('*')
            ->get();

        return $departments;
    }


    public function Get_Stock_Exp(Request $request)
    {

        $dateNow = Carbon::now();
        $req = $request->all();

        $month = $req['month'];
        $year = $req['year'];

        $Dep_select = $req['departments'];

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
            ->whereYear('packing.Exp_date', $year)
            ->whereMonth('packing.Exp_date', $month)
            ->where(function ($query) use ($dep_id, $Dep_select) {
                if ($dep_id != null) {
                    $query->where('orders.Department_id', $dep_id);
                }

                if ($Dep_select != null) {
                    $query->where('orders.Department_id', $Dep_select);
                }
            })
            ->orderBy('packing.Exp_date')
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
        $year = $req['year'];
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

        $List_Machine = DB::table('machine')
            ->select('*')
            ->where('machine.Machine_type', '!=', 'Wash&Disinfection')
            ->get();



        foreach ($List_Machine as $item) {

            $Cycle_Machine = DB::table('machine')
                ->selectRaw(' machine.*, count(DISTINCT packing.Cycle) as cycle_now , coa_report.coa_id, coa_report.`status`')
                ->leftjoin('packing', 'machine.Machine_id', '=', 'packing.Machine_id')
                ->leftjoin('coa_report', 'machine.Machine_id', '=', 'coa_report.machine_id')
                // ->whereYear('orders.Create_at', $year)
                ->where('machine.Machine_id', $item->Machine_id)
                ->where('machine.Machine_type', '!=', 'Wash&Disinfection')
                ->whereDate('coa_report.date', '=', Carbon::today()->toDateString())
                ->whereDate('packing.Create_at', '=', Carbon::today()->toDateString())
                ->groupBy('machine.Machine_id')
                ->first();

            $item->detail = $Cycle_Machine;

            // $Cycle_Machine_month = DB::table('packing')
            //     ->select('Create_at , Cycle')
            //     ->whereYear('packing.Create_at', $year)
            //     ->whereMonth('packing.Create_at', $month)
            //     ->where('Machine_id', $item->Machine_id)
            //     ->groupBy('Cycle')
            //     ->groupByRaw('CAST(Create_at AS DATE)')
            //     ->count();
            $Cycle_Machine_month = DB::table('packing')
                ->selectRaw('DISTINCT packing.Cycle , DATE(Create_at) , packing.Machine_id')
                ->whereYear('packing.Create_at', $year)
                ->whereMonth('packing.Create_at', $month)
                ->where('Machine_id', $item->Machine_id)
                // ->where('Cycle', '!=', '0')
                // ->groupBy('Cycle')
                // ->groupByRaw('CAST(Create_at AS DATE)')
                ->get();
            // dd(count($Cycle_Machine_month));

            $item->detail_month = count($Cycle_Machine_month);

            // Check COA_Report
            $check = DB::table('machine')
                ->selectRaw('MAX(packing.Cycle) AS Max_Cycle , coa_report.coa_id')
                ->leftjoin('packing', 'machine.Machine_id', '=', 'packing.Machine_id')
                ->leftjoin('coa_report', 'machine.Machine_id', '=', 'coa_report.machine_id')
                // ->whereYear('orders.Create_at', $year)
                ->where('machine.Machine_id', $item->Machine_id)
                ->where('machine.Machine_type', '!=', 'Wash&Disinfection')
                ->whereDate('coa_report.date', '=', Carbon::today()->toDateString())
                ->whereDate('packing.Create_at', '=', Carbon::today()->toDateString())
                ->whereRaw('coa_report.cycle = (SELECT MAX(packing.Cycle) FROM packing
                WHERE DATE(packing.Create_at) = "2022-11-19")')
                ->groupBy('machine.Machine_id')
                ->get();
            $item->check_COA = count($check);
        }

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
        $List->List_Machine = $List_Machine;
        return $List;
    }

    public function Get_Stock_Exp_csv_file(Request $request)
    {
        try {
            // dd($request);
            $dateNow = Carbon::now();
            $req = $request->all();

            $month = $req['month'];
            $year = $req['year'];

            $Dep_select = $req['departments'];

            $users_permit = new UsersPermission_Controller();

            // stock_exp
            $stock_exp = DB::table('stock')
                ->select('stock.*', 'packing.Exp_date', 'equipments.Name', 'departments.Department_name')
                ->leftjoin('packing', 'stock.item_id', '=', 'packing.item_id')
                ->leftjoin('orders', 'stock.Order_id', '=', 'orders.Order_id')
                ->leftjoin('items', 'stock.item_id', '=', 'items.item_id')
                ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftjoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
                ->whereYear('packing.Exp_date', $year)
                ->whereMonth('packing.Exp_date', $month)
                ->where(function ($query) use ($Dep_select) {
                    if ($Dep_select != null) {
                        $query->where('orders.Department_id', $Dep_select);
                    }
                })
                ->orderBy('packing.Exp_date')
                ->get();

            // return $stock_exp;
            // dd($stock_exp);

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เป็น Sheet ที่ 1
            $spreadsheet->getActiveSheet()->setTitle('Item EXP'); // ตั้งชื่อ Sheet

            $item_reports_head = [
                "A1" => "No.",
                "B1" => "ORDER ID",
                "C1" => "DEPARTMENT",
                "D1" => "ITEM ID",
                "E1" => "ITEM NAME",
                "F1" => "STOCK IN",
                "G1" => "STOCK OUT",
                "H1" => "EXP DATE"
            ];

            $spreadsheet->getActiveSheet()->fromArray($item_reports_head, null, 'A1', true, false); // นำข้อมูลมาแสดงใน Excel
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true); //ตั้งค่าตัวหนา
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType('solid')->getStartColor()->setARGB('002060'); // ตั้งค่าสีพื้นหลัง
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFF'); // ตั้งค่าสีตัวอักษร
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal('center'); // ตั้งค่าตำแหน่งให้อยู่ตรงกลาง

            $iteme_date = json_decode(json_encode($stock_exp), true);
            foreach ($iteme_date as $index => $item) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($index + 2), $index + 1);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($index + 2), $item['Order_id']);
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($index + 2), $item['Department_name']);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($index + 2), $item['item_id']);
                $spreadsheet->getActiveSheet()->setCellValue('E' . ($index + 2), $item['Name']);
                $spreadsheet->getActiveSheet()->setCellValue('F' . ($index + 2), $item['date_in_stock']);
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($index + 2), $item['date_out_stock']);
                $spreadsheet->getActiveSheet()->setCellValue('H' . ($index + 2), $item['Exp_date']);
            }

            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);

            // กำหนดชื่อไฟล์ และ ประเภทของไฟล์
            $file_export = "ReportItemEXP-" . $year . '_' . $month;
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
            header("Content-Transfer-Encoding: binary ");
            $writer->save('php://output');
        } catch (\Throwable $th) {
            echo "ไม่สามารถสร้างไฟล์ได้ เนื่องจากข้อมูลบางอย่างไม่ถูกต้อง หรือไม่มีข้อมูล";
            // dd($th);
        }
        exit();
    }
}