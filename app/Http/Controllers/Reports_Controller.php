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
use Excel;

class Reports_Controller extends BaseController
{
    public function ExportExcelWashingCycle(Request $request)
    {
        $report = new ReportsWashingCycle();
        $reportFrame = $report->collection('aa');
        return Excel::download($reportFrame, 'washing_cycle.xlsx');
    }
}
