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
    public function Get_Data(Request $request)
    {

        $dateNow = Carbon::now();
        $req = $request->all();

        $month = $dateNow->month - 1;
        $year = $dateNow->year;

        $departments = DB::table('departments')
            ->select('*')
            ->count();

        $customers = DB::table('customers')
            ->select('*')
            ->count();

        $item_month = DB::table('items')
            ->select('items.*')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->whereMonth('orders.Create_at', $month)
            ->count();

        $item_year = DB::table('items')
            ->select('items.*')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->whereYear('orders.Create_at', $year)
            ->count();

        // dd($item_month);

        $type_sterile = DB::select('SELECT SUM(CASE WHEN Situation_id = "STT-0001" THEN 1 ELSE 0 END) AS "Sterlie",
                SUM(CASE WHEN Situation_id = "STT-0002" THEN 1 ELSE 0 END) AS "Re-Sterlie",
                SUM(CASE WHEN Situation_id = "STT-0003" THEN 1 ELSE 0 END) AS "Claim",
                SUM(CASE WHEN Situation_id = "STT-0004" THEN 1 ELSE 0 END) AS "Borrow",
                SUM(CASE WHEN Situation_id = "STT-0005" THEN 1 ELSE 0 END) AS "Damage",
                SUM(CASE WHEN Situation_id = "STT-0003" THEN 1 ELSE 0 END) AS "Loss"
            FROM items
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            WHERE YEAR(orders.Create_at) = "' . $year . '"
            AND MONTH(orders.Create_at) = "' . $month . '"
        ')[0];
        // dd($type_sterile);


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

        $List = new \stdClass();
        $List->departments = $departments;
        $List->customers = $customers;
        $List->item_month = $item_month;
        $List->item_year = $item_year;
        $List->type_sterile = $type_sterile;
        $List->month_loss = $month_loss;

        dd($List);
    }
}