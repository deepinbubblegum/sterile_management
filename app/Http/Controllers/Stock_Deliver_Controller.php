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

    private function getOrderDetailItem($order_id)
    {
        $order_item = DB::table('items')
            ->select(
                'items.Item_id', 'items.Item_status', 'items.Quantity', 'situations.Situation_name',
                'equipments.Name', 'equipments.Price', 'equipments.Process'
            )
            ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->where('items.Order_id', $order_id)
            ->get();
        return $order_item;
    }


    private function m2t($number){
        $number = number_format($number, 2, '.', '');
        $numberx = $number;
        $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $number = str_replace(",","",$number);
        $number = str_replace(" ","",$number);
        $number = str_replace("บาท","",$number);
        $number = explode(".",$number);
        if(sizeof($number)>2){
            return 'ทศนิยมหลายตัวนะจ๊ะ';
            exit;
        }
        $strlen = strlen($number[0]);
        $convert = '';
        for($i=0;$i<$strlen;$i++){
            $n = substr($number[0], $i,1);
            if($n!=0){
                if($i==($strlen-1) AND $n==1){
                    $convert .= 'เอ็ด';
                }
                elseif($i==($strlen-2) AND $n==2){
                    $convert .= 'ยี่';
                }
                elseif($i==($strlen-2) AND $n==1){
                     $convert .= '';
                }
                else{
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen-$i-1];
            }
        }

        $convert .= 'บาท';
        if($number[1]=='0' OR $number[1]=='00' OR
        $number[1]==''){
            $convert .= 'ถ้วน';
        }else{
            $strlen = strlen($number[1]);
            for($i=0;$i<$strlen;$i++){
                $n = substr($number[1], $i,1);
                if($n!=0){
                    if($i==($strlen-1) AND $n==1){
                        $convert .= 'เอ็ด';
                }
                elseif($i==($strlen-2) AND $n==2){
                    $convert .= 'ยี่';
                }
                elseif($i==($strlen-2) AND $n==1){
                    $convert .= '';
                }
                else{
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen-$i-1];
            }
        }
        $convert .= 'สตางค์';
        }
        //แก้ต่ำกว่า 1 บาท ให้แสดงคำว่าศูนย์ แก้ ศูนย์บาท
        if($numberx < 1)
        {
            $convert = "ศูนย์" .  $convert;
        }

        //แก้เอ็ดสตางค์
        $len = strlen($numberx);
        $lendot1 = $len - 2;
        $lendot2 = $len - 1;
        if(($numberx[$lendot1] == 0) && ($numberx[$lendot2] == 1))
        {
            $convert = substr($convert,0,-10);
            $convert = $convert . "หนึ่งสตางค์";
        }

        //แก้เอ็ดบาท สำหรับค่า 1-1.99
        if($numberx >= 1)
        {
            if($numberx < 2)
            {
                $convert = substr($convert,4);
                $convert = "หนึ่ง" .  $convert;
            }
        }
        return $convert;
    }



    public function Deliver_pdf(Request $request)
    {

        $dateNow = Carbon::now();
        $orders_id = $request->route('oder_id');

        $items = DB::table('items')
            ->select('items.*', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'equipments.Item_Type', 'equipments.Expire', 'equipments.Instrument_type', 'situations.Situation_name', 'washing.washing_id', 'orders.Create_at')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
            ->leftjoin('washing', 'items.item_id', '=', 'washing.item_id')
            ->leftjoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->where('items.Order_id', $orders_id)
            ->where('items.Item_status', 'Stock')
            ->where('washing.PassStatus', 'Pass')
            // ->orderBy('items.item_id')
            // ->groupBy('items.item_id')
            ->orderByRaw('LENGTH(items.item_id)')
            ->get();

        $orders = DB::table('orders')
            ->select('orders.*', 'customers.*', 'departments.*', 'userCreate.Username as userCreate', 'userUpdate.Username as userUpdate',  'userApprove.Username as userApprove')
            ->leftJoin('customers', 'orders.Customer_id' , '=', 'customers.Customer_id')
            ->leftJoin('departments', 'orders.Department_id' , '=', 'departments.Department_id')
            ->leftjoin('users AS userCreate', 'orders.Create_by', '=', 'userCreate.user_id')
            ->leftjoin('users AS userUpdate', 'orders.Update_by', '=', 'userUpdate.user_id')
            ->leftjoin('users AS userApprove', 'orders.Approve_by', '=', 'userApprove.user_id')
            ->where('orders.Order_id', $orders_id)
            ->first();

        $user_deliver = DB::table('users')
        ->select('*')
        ->where('User_id', $request->cookie('Username_server_User_id'))
        ->first();

        $order_data_item = $this->getOrderDetailItem($orders_id);

        $total_price = 0.0;
        foreach ($order_data_item as $key => $item) {
            $total_price += $item->Price * $item->Quantity;
        }

        // dd($orders);
        $orders->Create_at_text = Carbon::parse($orders->Create_at)->format('d/m/Y');

        $List_data = new \stdClass();

        $List_data->price = [
            'total_price' => $total_price,
            'total_vat' => $total_price * 0.07,
            'total_price_vat' => $total_price * 1.07,
            'total_price_txt' => $this->m2t($total_price * 1.07)
        ];

        $List_data->qrcode_order = base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate($orders_id));
        $List_data->items = $items;
        $List_data->Order_id = $orders_id;
        $List_data->orders = $orders;
        $List_data->dateNow = $dateNow->format('d/m/Y');
        $List_data->User_Deliver = $user_deliver->Username;

        $pdf = PDF::loadView('pdf.Deliver', compact('List_data'));
        $pdf->setPaper('A4');

        return @$pdf->stream();
    }
}
