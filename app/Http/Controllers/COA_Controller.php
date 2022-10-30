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


use Illuminate\Support\Facades\File;

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

        $date = Carbon::parse($req['date']);


        $coa_ = DB::table('coa_report')
            ->select('coa_id')
            ->where('machine_id', $req['item_machines'])
            ->where('cycle', $req['input_Cycle'])
            ->where('date', $date)
            ->get();

        // Delete All Image Old
        if (count($coa_) != 0) {

            $image_Old = DB::table('coa_report_image')
                ->select('coa_report_image.*')
                ->where('coa_id', $coa_[0]->coa_id)
                ->get();

            foreach ($image_Old as $key => $value) {
                // dd($value->image);

                if (File::exists(public_path('assets/image/COA_Report/' . $value->image))) {
                    File::delete(public_path('assets/image/COA_Report/' . $value->image));
                }
            }

            DB::table('coa_report_image')->where('coa_id', $coa_[0]->coa_id)->delete();
        }


        if (count($coa_) != 0) {
            $coa_id = $coa_[0]->coa_id;
        } else {
            $coa_id = $req['coa_id'];
        }



        if ($coa_id == 'null' || $coa_id == null || $coa_id == '') {
            $coa_id = $this->AutuID();
        }


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


            if (isset($image_Old)  && count($image_Old) != 0) {
                $img_id = $image_Old[$key]->image_id;
            } else {
                $img_id = $req['img_id'][$key];
            }

            // dd($image_Old[$key]->image_id);

            if ($img_id == 'null' || $img_id == null || $img_id == '') {
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


    public function COA_Report_pdf(Request $request)
    {
        $dateNow = Carbon::now();
        $coa_id = $request->route('coa_id');

        $coa_report = DB::table('coa_report')
            ->select('*')
            ->leftjoin('machine', 'coa_report.Machine_id', '=', 'machine.Machine_id')
            ->where('coa_id', $coa_id)
            ->orderBy('coa_id', 'DESC')
            ->get();
        // dd($coa_report);
        $packing = DB::table('packing')
            ->select('packing.*', 'user_QC.Name as UserName_QC', 'user_create.Name as UserCreate', 'sterile_qc.Update_at as Update_Sterile')
            ->leftjoin('users as user_QC', 'packing.Qc_by', '=', 'user_QC.User_id')
            ->leftjoin('users as user_create', 'packing.Create_by', '=', 'user_create.User_id')
            ->leftJoin('sterile_qc', function ($join) {
                $join->on('packing.Order_id', '=', 'sterile_qc.Order_id');
                $join->on('packing.item_id', '=', 'sterile_qc.item_id');
            })
            ->where('Machine_id', $coa_report[0]->machine_id)
            ->where('Cycle', $coa_report[0]->cycle)
            ->whereDate('packing.Create_at', $coa_report[0]->date)
            ->orderBy('packing_id', 'DESC')
            ->first();


        $user_DB = DB::table('users')
            ->select('*')
            ->where('User_id', $request->cookie('Username_server_User_id'))
            ->first();

        // dd($packing);
        foreach ($coa_report as $item) {

            $image = DB::table('coa_report_image')
                ->select('coa_report_image.*')
                ->where('coa_id', $coa_id)
                ->get();

            $item->image = $image;
        }

        foreach ($item->image as $item) {
            // dd($item->image);
            $item->pathfile = public_path('assets/image/COA_Report/' . $item->image . '');
        }


        $coa_report[0]->Sterile_date_create = $packing->Create_at;
        $coa_report[0]->Sterile_date_Update = $packing->Update_Sterile;
        $coa_report[0]->UserCreate = $user_DB->Username;
        $coa_report[0]->UserName_QC = $packing->UserName_QC;

        $list_item = DB::table('items')
            ->select('items.*', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'equipments.Item_Type', 'equipments.Expire', 'equipments.Instrument_type', 'situations.Situation_name', 'equipments.Item_Type')
            ->leftjoin('equipments', 'items.Equipment_id', '=', 'equipments.Equipment_id')
            ->leftjoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
            ->leftJoin('packing', 'items.Item_id', '=', 'packing.item_id')
            // ->leftjoin('washing', 'items.item_id', '=', 'washing.item_id')
            ->where('packing.Machine_id', $coa_report[0]->machine_id)
            ->where('packing.Cycle', $coa_report[0]->cycle)
            ->whereDate('packing.Create_at', $coa_report[0]->date)
            ->distinct()
            ->orderBy('items.Order_id')
            ->orderByRaw('LENGTH(items.item_id)')
            ->get();
        // dd($list_item);
        // $item = $coa_report[0];

        $List_data = new \stdClass();
        $List_data->item = $coa_report[0];
        $List_data->list = $list_item;

        $pdf = PDF::loadView('pdf.COA_Report', compact('List_data'));
        $pdf->setPaper('A4');

        return @$pdf->stream();
    }
}