<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportsWashingCycle;

use Exception;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use PDF;
use QrCode;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Reports_Controller extends BaseController
{

    public function ExportExcelOrder(Request $request)
    {
        $data = $request->all();
        $customer_id = $request->customer;
        $department = $request->department;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $onlyapprove = $request->onlyapprove;

        $spreadsheet = new Spreadsheet();
        
        $customer = DB::table('customers')->where('Customer_id', $customer_id)->first();

        //ตั้งชื่อ Sheet
        $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->getActiveSheet()->setTitle('SUM Customer'); // ตั้งชื่อ Sheet
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'สรุปยอดรวมค่า Sterile อุปกรณ์ทางการแพทย์ ระหว่างวันที่ '.$date_start.' ถึงวันที่ '.$date_end);
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'รหัสลูกค้า / Customer Code: '.$customer->Customer_id); // กำหนดค่าใน cell A2
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'ชื่อ / Name: '.$customer->Customer_name); // กำหนดค่าใน cell A3
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true); //ตั้งค่าตัวหนา

        $dpartment_sum = DB::table('items')
                ->select('departments.Department_name', 'equipments.Name')
                ->selectRaw('SUM(items.Quantity) as Qty')
                ->selectRaw('equipments.Price')
                ->leftJoin('orders', 'items.Order_id', '=', 'orders.Order_id')
                ->leftJoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
                ->leftJoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
                ->leftJoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
                ->where('customers.Customer_id', $customer_id)
                ->whereBetween('orders.Create_at', [$date_start, $date_end])
                ->where(function ($query) use ($onlyapprove, $department) {
                    if ($onlyapprove == '1') {
                        $query->where('orders.StatusApprove', '=', '1');
                    }
                    if ($department != 'ALL') {
                        $query->where('orders.Department_id', '=', $department);
                    }
                })
                ->groupBy('departments.Department_id', 'equipments.Equipment_id')
                ->orderBy('departments.Department_name', 'asc')
                ->orderBy('orders.Create_at', 'asc')
                ->get();
        // dd($dpartment_sum);
        $dpartment_sum = json_decode(json_encode($dpartment_sum), true);
        $sum_headers = [
            'A4' => 'DEPARTMENT',
            'B4' => 'ITEM NAME',
            'C4' => 'QTY',
            'D4' => 'PRICE',
            'E4' => 'AMOUNT'
        ];
        $spreadsheet->getActiveSheet()->fromArray($sum_headers, null, 'A4', true, false);
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal('center'); // ตั้งค่าตำแหน่งตัวอักษร
        $spreadsheet->getActiveSheet()->getStyle('A1:E4')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal('center'); // ตั้งค่าตำแหน่งตัวอักษร

        $spreadsheet->getActiveSheet()->fromArray($dpartment_sum, null, 'A5', true, false);
        foreach($dpartment_sum as $key => $value){
            $spreadsheet->getActiveSheet()->setCellValue('E'.($key+5), '=C'.($key+5).'*D'.($key+5));
        }
        $spreadsheet->getActiveSheet()->setCellValue('A'.(count($dpartment_sum)+5), 'GRAND TOTAL: ');
        $spreadsheet->getActiveSheet()->setCellValue('C'.(count($dpartment_sum)+5), '=SUM(C5:C'.(count($dpartment_sum)+4).')');
        $spreadsheet->getActiveSheet()->setCellValue('E'.(count($dpartment_sum)+5), '=SUM(E5:E'.(count($dpartment_sum)+4).')');
        $spreadsheet->getActiveSheet()->getStyle('A'.(count($dpartment_sum)+5).':E'.(count($dpartment_sum)+5))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:E'.(count($dpartment_sum)+5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A'.(count($dpartment_sum)+5).':E'.(count($dpartment_sum)+5))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        $spreadsheet->getActiveSheet()->getStyle('D:E')->getNumberFormat()->setFormatCode('#,##0.00');
        // กำหนดให้ความกว้างของคอลัมน์เป็นอัตโนมัติ
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        // สร้างหน้าใหม่
        $spreadsheet->createSheet();

        $items = DB::table('items')
        ->select('departments.Department_name', 'orders.Create_at', 'equipments.Name', 'orders.Notes', 'items.Quantity', 'equipments.Price')
        ->leftJoin('orders', 'items.Order_id', '=', 'orders.Order_id')
        ->leftJoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
        ->leftJoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
        ->leftJoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
        ->where('customers.Customer_id', $customer_id)
        ->whereBetween('orders.Create_at', [$date_start, $date_end])
        ->where(function ($query) use ($onlyapprove, $department) {
            if ($onlyapprove == '1') {
                $query->where('orders.StatusApprove', '=', '1');
            }
            if ($department != 'ALL') {
                $query->where('orders.Department_id', '=', $department);
            }
        })
        ->orderBy('departments.Department_name', 'ASC')
        ->orderBy('orders.Create_at', 'ASC')
        ->get();
        $items = json_decode(json_encode($items), true);

        // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->setActiveSheetIndex(1);

        // $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma'); // กำหนด Font ทั้งหมดในไฟล์
        // $spreadsheet->getDefaultStyle()->getFont()->setSize(11);
        $spreadsheet->getActiveSheet()->setTitle($date_start.'_'.$date_end); // ตั้งชื่อ Sheet ว่า WashingCycle All

        $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
        $spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells("A2:I2");
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells("A3:I3");
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'สรุปยอดรวมค่า Sterile อุปกรณ์ทางการแพทย์ ระหว่างวันที่ '.$date_start.' ถึงวันที่ '.$date_end); // กำหนดค่าใน cell A1
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'รหัสลูกค้า / Customer Code: '.$customer->Customer_id); // กำหนดค่าใน cell A2
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'ชื่อ / Name: '.$customer->Customer_name); // กำหนดค่าใน cell A3

        $item_reports_head = [
            'DEPARTMENT',
            'REQUEST DATE',
            'ITEM NAME',
            'REMARK',
            'QTY',
            'UNIT PRICE',
            'AMOUNT',
            'VAT7%',
            'TOTAL'
        ];
        $spreadsheet->getActiveSheet()->fromArray($item_reports_head, null, 'A4', true, false);
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);    //ตั้งค่าตัวหนา
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        
        $spreadsheet->getActiveSheet()->getStyle('F:I')->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->fromArray($items, null, 'A5', true, false);

        // กำหนดให้ความกว้างของคอลัมน์เป็นอัตโนมัติ
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('E:I')->getAlignment()->setHorizontal('center');

        $index = 0;
        foreach ($items as $key => $value) {
            $spreadsheet->getActiveSheet()->setCellValue('G'.($key+5), '=E'.($key+5).'*F'.($key+5));
            $spreadsheet->getActiveSheet()->setCellValue('H'.($key+5), '=G'.($key+5).'*0.07');
            $spreadsheet->getActiveSheet()->setCellValue('I'.($key+5), '=G'.($key+5).'+H'.($key+5));
            $index = $key+5;
        }
        $spreadsheet->getActiveSheet()->setCellValue('A'.($index+2), 'GRAND TOTAL');
        $spreadsheet->getActiveSheet()->setCellValue('E'.($index+2), '=SUM(E5:E'.($index+1).')');
        $spreadsheet->getActiveSheet()->setCellValue('G'.($index+2), '=SUM(G5:G'.($index+1).')');
        $spreadsheet->getActiveSheet()->setCellValue('H'.($index+2), '=SUM(H5:H'.($index+1).')');
        $spreadsheet->getActiveSheet()->setCellValue('I'.($index+2), '=SUM(I5:I'.($index+1).')');
        $spreadsheet->getActiveSheet()->getStyle('A'.($index+2).':I'.($index+2))->getFont()->setBold(true);    //ตั้งค่าตัวหนา
        // $spreadsheet->getActiveSheet()->getStyle('A'.($index+2).':I'.($index+2))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        // $spreadsheet->getActiveSheet()->getStyle('A4:I'.($index+2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('000000')); // ตั้งค่าสีเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A4:I'.($index+2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A'.($index+2).':I'.($index+2))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง

        $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เปิด sheet แรกเป็น sheet ที่แสดงผล
        // เขียนข้อมูลลงไฟล์ 
        $writer = new Xlsx($spreadsheet);
        
        // กำหนดชื่อไฟล์ และ ประเภทของไฟล์
        $file_export= "CommercialReport-". carbon::now()->format('YmdHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_export.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $writer->save('php://output');
        exit();
    }

    public function getListCustomers(Request $request)
    {
        $recv = $request->all();
        $getCustomerList = DB::table('customers')
                    ->select('customers.*')
                    ->get();
        return $getCustomerList;
    }

    public function getListDepartments(Request $request)
    {
        $recv = $request->all();
        $Customer_id = $recv['Customer_id'];
        $getDepartmentList = DB::table('departments')
                    ->select('departments.*')
                    ->where('Customer_id', $Customer_id)
                    ->get();
        return $getDepartmentList;
    }
}
