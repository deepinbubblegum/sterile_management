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

class Reports_Controller extends BaseController
{
    public function ExportExcelWashingCycle(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        //ตั้งชื่อ Sheet
        $spreadsheet->setActiveSheetIndex(0); // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->getActiveSheet()->setTitle('WashingCycle');

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Hello World !'); // กำหนดค่าใน cell A1
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', 'ทดสอบข้อความภาษาไทย !'); // กำหนดค่าใน cell B1

        // สร้างหน้าใหม่
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1); // กำหนดให้เป็น Sheet ที่ 2
        $spreadsheet->getActiveSheet()->setTitle('Sheet2'); // ตั้งชื่อ Sheet
        $spreadsheet->setActiveSheetIndex(1)->setCellValue('A1', 'sheet2'); // กำหนดค่าใน cell A1
        $spreadsheet->setActiveSheetIndex(1)->setCellValue('B1', 'ทดสอบข้อความภาษาไทย !'); // กำหนดค่าใน cell B1
        
        // กำหนดให้เป็น Sheet ที่ 1
        $spreadsheet->setActiveSheetIndex(0);
        // เขียนข้อมูลลงไฟล์ 
        $writer = new Xlsx($spreadsheet);
        
        // กำหนดชื่อไฟล์ และ ประเภทของไฟล์
        $file_export= "WashingCycle-". carbon::now()->format('YmdHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_export.'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $writer->save('php://output');
        exit();
    }
}
