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

class Stock_Deliver_Controller extends BaseController
{
    public function Deliver_pdf(Request $request)
    {

        $dateNow = Carbon::now();
        $oder_id = $request->route('oder_id');

        $items = DB::table('items')
            ->select('items.*', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'equipments.Item_Type', 'equipments.Expire', 'equipments.Instrument_type', 'situations.Situation_name', 'washing.washing_id', 'orders.Create_at')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
            ->leftjoin('washing', 'items.item_id', '=', 'washing.item_id')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->where('items.Order_id', $oder_id)
            ->where('items.Item_status', 'Stock')
            // ->orderBy('items.item_id')
            ->orderByRaw('LENGTH(items.item_id)')
            ->get();

        $List_data = new \stdClass();
        $List_data->items = $items;
        $List_data->Order_id = $oder_id;
        $List_data->dateNow = $dateNow->format('d/m/Y');
        $List_data->Create_by = $request->cookie('Username_server_User_id');

        $pdf = PDF::loadView('pdf.Deliver', compact('List_data'));
        $pdf->setPaper('A4');

        return @$pdf->stream();
    }
}
