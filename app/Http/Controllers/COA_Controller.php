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

class COA_Controller extends BaseController
{

    private function AutuID()
    {
        $oid = DB::select(
            'SELECT CONCAT("COA-",LPAD(SUBSTRING(IFNULL(MAX(coa_report.coa_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM coa_report'
        );
        return $oid[0]->auto_id;
    }

    private function AutuIDImg()
    {
        $oid = DB::select(
            'SELECT CONCAT("IMG_COA-",LPAD(SUBSTRING(IFNULL(MAX(image_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM coa_report_image'
        );
        return $oid[0]->auto_id;
    }

    public function Get_machine()
    {
        try {

            $return_data = new \stdClass();

            $items_machine = DB::table('machine')
                ->select('machine.*')
                ->where('Active', '1')
                ->get();

            $return_data->code = '0000';
            $return_data->machine = $items_machine;


            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function Get_COA(Request $request)
    {
        try {

            $return_data = new \stdClass();
            $data = $request->all();

            $coa_report = DB::table('coa_report')
                ->select('*')
                ->leftjoin('machine', 'coa_report.Machine_id', '=', 'machine.Machine_id')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('coa_report.Machine_id', $data['txt_search']);
                    }
                })
                ->orderBy('coa_id', 'DESC')
                ->paginate(10);

            foreach ($coa_report as $item) {

                $image = DB::table('coa_report_image')
                    ->select('coa_report_image.*')
                    ->where('coa_id', $item->coa_id)
                    ->get();
                $item->image = $image;
            }

            $return_data->code = '0000';
            $return_data->COA = $coa_report;


            return $return_data;
        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '1000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function New_COA_report(Request $request)
    {
        $req = $request->all();

        $coa_id = $req['coa_id'];


        if ($coa_id == 'null' || $coa_id == null || $coa_id == '') {
            $coa_id = $this->AutuID();
        }

        $date = Carbon::parse($req['date']);

        DB::table('coa_report')->updateOrInsert(
            [
                'machine_id' => $req['item_machines'],
                'cycle' => $req['input_Cycle'],
                'date' => $date,
            ],
            [
                'coa_id' => $coa_id,
                'machine_id' => $req['item_machines'],
                'cycle' => $req['input_Cycle'],
                'date' => $date,
            ]
        );

        foreach ($req['img'] as $key => $value) {

            $img_id = $req['img_id'][$key];


            if ($img_id == 'null' || $img_id == null || $img_id == '' || $img_id == '-') {
                $img_id = $this->AutuIDImg();
            }

            $imageName = $img_id . '.' . $value->getClientOriginalExtension();
            $value->move(public_path('assets/image/COA_Report'), $imageName);


            DB::table('coa_report_image')->updateOrInsert(
                [
                    'coa_id' => $coa_id,
                    'image_id' => $img_id,
                ],
                [
                    'coa_id' => $coa_id,
                    'coa_type' => $req['type'][$key],
                    'image_id' => $img_id,
                    'image' => $imageName,

                ]
            );
        }

        return true;
    }
}