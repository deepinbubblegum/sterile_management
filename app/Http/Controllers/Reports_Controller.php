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

        // dd(date('Y-m-d', strtotime('+1 day', strtotime($date_end))));

        $spreadsheet = new Spreadsheet();

        $customer = DB::table('customers')->where('Customer_id', $customer_id)->first();

        //ตั้งชื่อ Sheet
        $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->getActiveSheet()->setTitle('SUM Customer'); // ตั้งชื่อ Sheet
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'สรุปยอดรวมค่า Sterile อุปกรณ์ทางการแพทย์ ระหว่างวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end);
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'รหัสลูกค้า / Customer Code: ' . $customer->Customer_id); // กำหนดค่าใน cell A2
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'ชื่อ / Name: ' . $customer->Customer_name); // กำหนดค่าใน cell A3
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
            ->whereBetween('orders.Create_at', [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end)))])
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
        foreach ($dpartment_sum as $key => $value) {
            $spreadsheet->getActiveSheet()->setCellValue('E' . ($key + 5), '=C' . ($key + 5) . '*D' . ($key + 5));
        }
        $spreadsheet->getActiveSheet()->setCellValue('A' . (count($dpartment_sum) + 5), 'GRAND TOTAL: ');
        $spreadsheet->getActiveSheet()->setCellValue('C' . (count($dpartment_sum) + 5), '=SUM(C5:C' . (count($dpartment_sum) + 4) . ')');
        $spreadsheet->getActiveSheet()->setCellValue('E' . (count($dpartment_sum) + 5), '=SUM(E5:E' . (count($dpartment_sum) + 4) . ')');
        $spreadsheet->getActiveSheet()->getStyle('A' . (count($dpartment_sum) + 5) . ':E' . (count($dpartment_sum) + 5))->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:E' . (count($dpartment_sum) + 5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A' . (count($dpartment_sum) + 5) . ':E' . (count($dpartment_sum) + 5))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        $spreadsheet->getActiveSheet()->getStyle('D:E')->getNumberFormat()->setFormatCode('#,##0.00');
        // กำหนดให้ความกว้างของคอลัมน์เป็นอัตโนมัติ
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        // สร้างหน้าใหม่
        $spreadsheet->createSheet();

        $items = DB::table('items')
            ->select('departments.Department_name', 'orders.Create_at', 'orders.Order_id', 'equipments.Name', 'orders.Notes', 'items.Quantity', 'equipments.Price')
            ->leftJoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->leftJoin('departments', 'orders.Department_id', '=', 'departments.Department_id')
            ->leftJoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->leftJoin('customers', 'orders.Customer_id', '=', 'customers.Customer_id')
            ->where('customers.Customer_id', $customer_id)
            ->whereBetween('orders.Create_at', [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end)))])
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
        // dd($items);
        // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->setActiveSheetIndex(1);

        // $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma'); // กำหนด Font ทั้งหมดในไฟล์
        // $spreadsheet->getDefaultStyle()->getFont()->setSize(11);
        $spreadsheet->getActiveSheet()->setTitle($date_start . '_' . $date_end); // ตั้งชื่อ Sheet ว่า WashingCycle All

        $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
        $spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells("A2:I2");
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->mergeCells("A3:I3");
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'สรุปยอดรวมค่า Sterile อุปกรณ์ทางการแพทย์ ระหว่างวันที่ ' . $date_start . ' ถึงวันที่ ' . $date_end); // กำหนดค่าใน cell A1
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'รหัสลูกค้า / Customer Code: ' . $customer->Customer_id); // กำหนดค่าใน cell A2
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'ชื่อ / Name: ' . $customer->Customer_name); // กำหนดค่าใน cell A3

        $item_reports_head = [
            'DEPARTMENT',
            'REQUEST DATE',
            'REQUEST ID',
            'ITEM NAME',
            'REMARK',
            'QTY',
            'UNIT PRICE',
            'AMOUNT',
            'VAT7%',
            'TOTAL'
        ];
        $spreadsheet->getActiveSheet()->fromArray($item_reports_head, null, 'A4', true, false);
        $spreadsheet->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true);    //ตั้งค่าตัวหนา
        $spreadsheet->getActiveSheet()->getStyle('A4:J4')->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง

        $spreadsheet->getActiveSheet()->getStyle('G:J')->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->fromArray($items, null, 'A5', true, false);

        // กำหนดให้ความกว้างของคอลัมน์เป็นอัตโนมัติ
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('F:J')->getAlignment()->setHorizontal('center');

        $index = 0;
        foreach ($items as $key => $value) {
            $spreadsheet->getActiveSheet()->setCellValue('H' . ($key + 5), '=F' . ($key + 5) . '*G' . ($key + 5));
            $spreadsheet->getActiveSheet()->setCellValue('I' . ($key + 5), '=H' . ($key + 5) . '*0.07');
            $spreadsheet->getActiveSheet()->setCellValue('J' . ($key + 5), '=H' . ($key + 5) . '+I' . ($key + 5));
            // $spreadsheet->getActiveSheet()->setCellValue('G' . ($key + 5), '=E' . ($key + 5) . '*F' . ($key + 5));
            // $spreadsheet->getActiveSheet()->setCellValue('H' . ($key + 5), '=G' . ($key + 5) . '*0.07');
            // $spreadsheet->getActiveSheet()->setCellValue('I' . ($key + 5), '=G' . ($key + 5) . '+H' . ($key + 5));
            $index = $key + 5;
        }
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($index + 2), 'GRAND TOTAL');
        $spreadsheet->getActiveSheet()->setCellValue('F' . ($index + 2), '=SUM(F5:F' . ($index + 1) . ')');
        $spreadsheet->getActiveSheet()->setCellValue('H' . ($index + 2), '=SUM(H5:H' . ($index + 1) . ')');
        $spreadsheet->getActiveSheet()->setCellValue('I' . ($index + 2), '=SUM(I5:I' . ($index + 1) . ')');
        $spreadsheet->getActiveSheet()->setCellValue('J' . ($index + 2), '=SUM(J5:J' . ($index + 1) . ')');
        $spreadsheet->getActiveSheet()->getStyle('A' . ($index + 2) . ':J' . ($index + 2))->getFont()->setBold(true);    //ตั้งค่าตัวหนา
        // $spreadsheet->getActiveSheet()->getStyle('A'.($index+2).':I'.($index+2))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        // $spreadsheet->getActiveSheet()->getStyle('A4:I'.($index+2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK)->setColor(new Color('000000')); // ตั้งค่าสีเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A4:J' . ($index + 2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
        $spreadsheet->getActiveSheet()->getStyle('A' . ($index + 2) . ':J' . ($index + 2))->getFill()->setFillType('solid')->getStartColor()->setARGB('A9D08E'); // ตั้งค่าสีพื้นหลัง
        $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');
        $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เปิด sheet แรกเป็น sheet ที่แสดงผล
        // เขียนข้อมูลลงไฟล์
        $writer = new Xlsx($spreadsheet);

        // กำหนดชื่อไฟล์ และ ประเภทของไฟล์
        $file_export = "CommercialReport-" . carbon::now()->format('YmdHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
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

    public function ExportExcelProcess(Request $request)
    {

        try {
            $recv = $request->all();
            $customer_id = $request->customer;
            $department = $request->department;
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $onlyapprove = $request->onlyapprove;

            // dd($customer_id, $department, $date_start, $date_end, $onlyapprove);

            $items = DB::select(
                'SELECT
                departments.Department_name,
                SUM(CASE WHEN equipments.Process = "STEAM" THEN 1 ELSE 0 END) AS "STEAM",
                SUM(CASE WHEN equipments.Process = "plasma" THEN 1 ELSE 0 END) AS "plasma",
                SUM(CASE WHEN equipments.Process = "eo" THEN 1 ELSE 0 END) AS "eo",
                SUM(CASE WHEN equipments.Process = "Wash&Disinfection" THEN 1 ELSE 0 END) AS "Wash&Disinfection"
            FROM items
            LEFT JOIN equipments ON items.Equipment_id = equipments.Equipment_id
            LEFT JOIN orders ON orders.Order_id = items.Order_id
            LEFT JOIN departments ON orders.Department_id = departments.Department_id
            WHERE orders.Create_at BETWEEN ? AND ?
            AND orders.Customer_id = ?
            GROUP BY departments.Department_name',
                [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id]
            );

            $spreadsheet = new Spreadsheet();

            $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เป็น Sheet ที่ 1
            $spreadsheet->getActiveSheet()->setTitle('WARD QTY'); // ตั้งชื่อ Sheet

            $item_reports_head = [
                "A1" => "No.",
                "B1" => "DEPARTMENT",
                "C1" => "STEAM",
                "D1" => "PLASMA",
                "E1" => "EO",
                "F1" => "WASH & DISINFECTION",
                "G1" => "GRAND TOTAL"
            ];

            $spreadsheet->getActiveSheet()->fromArray($item_reports_head, null, 'A1', true, false); // นำข้อมูลมาแสดงใน Excel
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true); //ตั้งค่าตัวหนา
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType('solid')->getStartColor()->setARGB('002060'); // ตั้งค่าสีพื้นหลัง
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFF'); // ตั้งค่าสีตัวอักษร
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal('center'); // ตั้งค่าตำแหน่งให้อยู่ตรงกลาง

            foreach ($items as $index => $item_report) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($index + 2), $index + 1);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($index + 2), $item_report->Department_name);
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($index + 2), $item_report->STEAM);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($index + 2), $item_report->plasma);
                $spreadsheet->getActiveSheet()->setCellValue('E' . ($index + 2), $item_report->eo);
                $spreadsheet->getActiveSheet()->setCellValue('F' . ($index + 2), $item_report->{'Wash&Disinfection'});
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($index + 2), '=SUM(C' . ($index + 2) . ':F' . ($index + 2) . ')');
            }

            $spreadsheet->getActiveSheet()->getStyle('A1:G' . (count($items) + 2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ
            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center'); // ตั้งค่าตำแหน่งให้อยู่ตรงกลาง

            $spreadsheet->getActiveSheet()->setCellValue('A' . (count($items) + 2), 'Grand Total');
            $spreadsheet->getActiveSheet()->setCellValue('C' . (count($items) + 2), '=SUM(C2:C' . (count($items) + 1) . ')');
            $spreadsheet->getActiveSheet()->setCellValue('D' . (count($items) + 2), '=SUM(D2:D' . (count($items) + 1) . ')');
            $spreadsheet->getActiveSheet()->setCellValue('E' . (count($items) + 2), '=SUM(E2:E' . (count($items) + 1) . ')');
            $spreadsheet->getActiveSheet()->setCellValue('F' . (count($items) + 2), '=SUM(F2:F' . (count($items) + 1) . ')');
            $spreadsheet->getActiveSheet()->setCellValue('G' . (count($items) + 2), '=SUM(G2:G' . (count($items) + 1) . ')');

            $spreadsheet->getActiveSheet()->getStyle('A' . (count($items) + 2) . ':G' . (count($items) + 2))->getFont()->setBold(true); //ตั้งค่าตัวหนา
            $spreadsheet->getActiveSheet()->getStyle('A' . (count($items) + 2) . ':G' . (count($items) + 2))->getFill()->setFillType('solid')->getStartColor()->setARGB('FFC000'); // ตั้งค่าสีพื้นหลัง

            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            if ($department == "ALL") {
                if ($onlyapprove == '1') {
                    $iteme_date = DB::select("CALL items_date_data(?, ?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department, $onlyapprove]);
                } else {
                    $iteme_date = DB::select("CALL items_date_data_Approve_Status(?, ?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department, $onlyapprove]);
                }
            } else {
                if ($onlyapprove == '1') {
                    $iteme_date = DB::select("CALL items_date_data_Approve_Status_department(?, ?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department, $onlyapprove]);
                } else {
                    $iteme_date = DB::select("CALL items_date_data_department(?, ?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department, $onlyapprove]);
                }
            }


            // สร้างหน้าใหม่
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $spreadsheet->getActiveSheet()->setTitle('ITEMS QTY');

            $iteme_date = json_decode(json_encode($iteme_date), true);
            $header_qty = array();
            foreach ($iteme_date[0] as $key => $value) {
                array_push($header_qty, $key);
            }
            array_push($header_qty, 'Grand Total');
            $spreadsheet->getActiveSheet()->fromArray($header_qty, null, 'A1');
            $spreadsheet->getActiveSheet()->fromArray($iteme_date, null, 'A2', false, false);

            $sheet = $spreadsheet->getActiveSheet();
            $column_qty = "A";
            $column_qty_array = array();
            foreach ($sheet->getColumnIterator() as $column) {
                $column_qty = $column->getColumnIndex();
                array_push($column_qty_array, $column_qty);
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_qty . '1')->getFill()->setFillType('solid')->getStartColor()->setARGB('002060');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_qty . '1')->getFont()->getColor()->setARGB('FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_qty . '1')->getFont()->setBold(true);

            for ($i = 2; $i <= count($iteme_date) + 1; $i++) {
                $spreadsheet->getActiveSheet()->setCellValue($column_qty . $i, '=SUM(B' . $i . ':' . ($column_qty_array[count($column_qty_array) - 2]) . $i . ')');
                $spreadsheet->getActiveSheet()->getStyle($column_qty . $i)->getNumberFormat()->setFormatCode('#,##0');
            }

            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_qty . (count($iteme_date) + 2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ

            foreach ($sheet->getColumnIterator() as $column) {
                if ($column->getColumnIndex() != 'A') {
                    $spreadsheet->getActiveSheet()->setCellValue($column->getColumnIndex() . (count($iteme_date) + 2), '=SUM(' . $column->getColumnIndex() . '2:' . $column->getColumnIndex() . (count($iteme_date) + 1) . ')');
                    $spreadsheet->getActiveSheet()->getStyle($column->getColumnIndex() . (count($iteme_date) + 2))->getNumberFormat()->setFormatCode('#,##0');
                }
            }
            $spreadsheet->getActiveSheet()->setCellValue('A' . (count($iteme_date) + 2), 'Grand Total');
            $spreadsheet->getActiveSheet()->getStyle('A' . (count($iteme_date) + 2) . ':' . $column_qty . (count($iteme_date) + 2))->getFont()->setBold(true); //ตั้งค่าตัวหนา
            $spreadsheet->getActiveSheet()->getStyle('A' . (count($iteme_date) + 2) . ':' . $column_qty . (count($iteme_date) + 2))->getFill()->setFillType('solid')->getStartColor()->setARGB('FFC000'); // ตั้งค่าสีพื้นหลัง

            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }

            // สร้างหน้าใหม่
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(2);
            $spreadsheet->getActiveSheet()->setTitle('REPORT Washing Cycle');

            if ($department == "ALL") {
                $report_cycle = DB::select("CALL report_cycle_customer(?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department]);
            } else {
                $report_cycle = DB::select("CALL report_cycle_customer_department(?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department]);
            }

            $report_cycle = json_decode(json_encode($report_cycle), true);
            $report_cycle_header = array();
            foreach ($report_cycle[0] as $key => $value) {
                array_push($report_cycle_header, $key);
            }
            array_push($report_cycle_header, 'Cycle Total');
            $spreadsheet->getActiveSheet()->fromArray($report_cycle_header, null, 'A1');
            $spreadsheet->getActiveSheet()->fromArray($report_cycle, null, 'A2', false, false);

            $sheet = $spreadsheet->getActiveSheet();
            $column_cycle = "A";
            $column_cycle_array = array();
            foreach ($sheet->getColumnIterator() as $column) {
                $column_cycle = $column->getColumnIndex();
                array_push($column_cycle_array, $column_cycle);
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFill()->setFillType('solid')->getStartColor()->setARGB('002060');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFont()->getColor()->setARGB('FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFont()->setBold(true);

            for ($i = 2; $i <= count($report_cycle) + 1; $i++) {
                $spreadsheet->getActiveSheet()->setCellValue($column_cycle . $i, '=SUM(B' . $i . ':' . ($column_cycle_array[count($column_cycle_array) - 2]) . $i . ')');
                $spreadsheet->getActiveSheet()->getStyle($column_cycle . $i)->getNumberFormat()->setFormatCode('#,##0');
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . (count($report_cycle) + 2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ

            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
            // dd($column_qty_array);

            // สร้างหน้าใหม่
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(3);
            $spreadsheet->getActiveSheet()->setTitle('REPORT Sterile Cycle');

            if ($department == "ALL") {
                $sterile_cycle = DB::select("CALL sterile_machine_cycle(?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department]);
            } else {
                $sterile_cycle = DB::select("CALL sterile_machine_cycle_department(?, ?, ?, ?)", [$date_start, date('Y-m-d', strtotime('+1 day', strtotime($date_end))), $customer_id, $department]);
            }

            $sterile_cycle = json_decode(json_encode($sterile_cycle), true);
            $sterile_cycle_header = array();
            foreach ($sterile_cycle[0] as $key => $value) {
                array_push($sterile_cycle_header, $key);
            }
            array_push($sterile_cycle_header, 'Cycle Total');
            $spreadsheet->getActiveSheet()->fromArray($sterile_cycle_header, null, 'A1');
            $spreadsheet->getActiveSheet()->fromArray($sterile_cycle, null, 'A2', false, false);

            $sheet = $spreadsheet->getActiveSheet();
            $column_cycle = "A";
            $column_cycle_array = array();
            foreach ($sheet->getColumnIterator() as $column) {
                $column_cycle = $column->getColumnIndex();
                array_push($column_cycle_array, $column_cycle);
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFill()->setFillType('solid')->getStartColor()->setARGB('002060');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFont()->getColor()->setARGB('FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . '1')->getFont()->setBold(true);

            for ($i = 2; $i <= count($sterile_cycle) + 1; $i++) {
                $spreadsheet->getActiveSheet()->setCellValue($column_cycle . $i, '=SUM(B' . $i . ':' . ($column_cycle_array[count($column_cycle_array) - 2]) . $i . ')');
                $spreadsheet->getActiveSheet()->getStyle($column_cycle . $i)->getNumberFormat()->setFormatCode('#,##0');
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $column_cycle . (count($sterile_cycle) + 2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // ตั้งค่าเส้นขอบ

            $sheet = $spreadsheet->getActiveSheet();
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }


            $spreadsheet->setActiveSheetIndex(0);
            // เขียนข้อมูลลงไฟล์
            $writer = new Xlsx($spreadsheet);

            // กำหนดชื่อไฟล์ และ ประเภทของไฟล์
            $file_export = "ReportProcess-" . carbon::now()->format('YmdHis');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
            header("Content-Transfer-Encoding: binary ");
            $writer->save('php://output');
        } catch (\Throwable $th) {
            echo "ไม่สามารถสร้างไฟล์ได้ เนื่องจากข้อมูลบางอย่างไม่ถูกต้อง หรือไม่มีข้อมูล";
        }
        exit();
    }
}