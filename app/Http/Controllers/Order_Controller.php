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

class Order_Controller extends BaseController
{
    public function getListOrder(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();

            $users = DB::table('orders')
                ->select('orders.*',  'userCreate.Username as userCreate', 'userUpdate.Username as userUpdate',  'userApprove.Username as userApprove', 'customers.Customer_name', 'departments.Department_name')
                ->leftjoin('users AS userCreate', 'orders.Create_by', '=', 'userCreate.user_id')
                ->leftjoin('users AS userUpdate', 'orders.Update_by', '=', 'userUpdate.user_id')
                ->leftjoin('users AS userApprove', 'orders.Approve_by', '=', 'userApprove.user_id')
                ->leftjoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
                ->leftjoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('order_id', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('order_id', 'desc')
                ->paginate(8);

            $return_data->orders = $users;

            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function delOrder(Request $request)
    {
        $recv = $request->all();
        $id = $recv['id'];
        DB::table('orders')->where('Order_id', $id)->delete();
        return json_encode(true);
    }

    private function getOrderDetail($order_id)
    {
        $order_data = DB::table('orders')
            ->select(
                'orders.Order_id', 'orders.Department_id', 'orders.Create_at',  'orders.Approve_at', 
                'customers.Customer_name', 'departments.Department_name', 'userCreate.Name as Create_byName',
                'userApprove.Name as Approve_byName'
            )
            ->leftjoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
            ->leftjoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
            ->leftjoin('users as userCreate', 'orders.Create_by', '=', 'userCreate.user_id')
            ->leftjoin('users as userApprove', 'orders.Approve_by', '=', 'userApprove.user_id')
            ->where('orders.Order_id', $order_id)
            ->get();
        return $order_data;
    }

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

    // function gen order pdf
    public function getOrderPDF(Request $request)
    {
        $recv = $request->all();
        $id = $recv['orderid'];
        $current = Carbon::now();
        $print_by = $request->cookie('Username_server_Name');
        $order_data = $this->getOrderDetail($id);
        $order_data_item = $this->getOrderDetailItem($id);
        // dd($order_data_item);
        $total_price = 0.0;
        foreach ($order_data_item as $key => $item) {
            $total_price += $item->Price * $item->Quantity;
        }

        $data = [
            'qrcode_order' => base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate('string')),
            'order_id' => $id,
            'order_date' => $current->format('d/m/Y'),
            'print_by' => $print_by,
            'customer_name' => $order_data[0]->Customer_name,
            'department_name' => $order_data[0]->Department_name,
            'create_by' => $order_data[0]->Create_byName,
            'approve_by' => $order_data[0]->Approve_byName,
            'create_at' => $order_data[0]->Create_at,
            'approve_at' => $order_data[0]->Approve_at,
            'order_item' => $order_data_item,
            'total_price' => $total_price,
            'total_vat' => $total_price * 0.07,
            'total_price_vat' => $total_price * 1.07,
            'total_price_txt' => $this->m2t($total_price * 1.07)
        ];
          
        $pdf = PDF::loadView('pdf.order', $data);
        $pdf->setPaper('A4');
    
        return @$pdf->stream();
    }
}
