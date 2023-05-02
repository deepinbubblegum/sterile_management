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

class MachinesSterile_Controller extends BaseController
{
    public function getListMachinesSterile(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();
            $machines = DB::table('machine')
                ->select('machine.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('machine.Machine_name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('machine.Machine_id', 'desc')
                ->paginate(8);
            $return_data->machines = $machines;
            return $return_data;

        } catch (\Throwable $th) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $th->getMessage();

            return $return_data;
        }
    }

    private function autoIdMachine()
    {
        $mslid = DB::select(
            'SELECT CONCAT("MSL-",LPAD(SUBSTRING(IFNULL(MAX(machine.Machine_id), "0"), 5,6)+1, 5,"0")) as auto_id FROM machine'
        );
        return $mslid[0]->auto_id;
    }

    public function createMachinesSterile(Request $request)
    {
        $recv = $request->all();
        $machine_id = $this->autoIdMachine();
        $machines_name = $recv['machines_name'];
        $machines_type = $recv['machines_type'];
        $machines_status = DB::table('machine')
            ->insert([
                'Machine_id' => $machine_id,
                'Machine_name' => $machines_name,
                'Machine_type' => $machines_type,
            ]);
        return $machines_status;
    }

    public function getMachinesSterileDetail(Request $request)
    {
        $recv = $request->all();
        $machine_id = $recv['machine_id'];
        $machines = DB::table('machine')
            ->select('machine.*')
            ->where('machine.Machine_id', $machine_id)
            ->first();
        return $machines;
    }

    public function updateMachinesSterile(Request $request)
    {
        $recv = $request->all();
        $machine_id = $recv['machine_id'];
        $machines_name = $recv['machine_name'];
        $machines_type = $recv['machine_type'];
        $machines_status = DB::table('machine')
            ->where('Machine_id', $machine_id)
            ->update([
                'Machine_name' => $machines_name,
                'Machine_type' => $machines_type,
            ]);
        return $machines_status;
    }

    public function deleteMachinesSterile(Request $request)
    {
        $recv = $request->all();
        $machine_id = $recv['machine_id'];
        $machines_status = DB::table('machine')
            ->where('Machine_id', $machine_id)
            ->delete();
        return $machines_status;
    }

    public function toggleActivate(Request $request)
    {
        $recv = $request->all();
        $machine_id = $recv['machine_id'];
        $machines_status = DB::table('machine')
            ->where('Machine_id', $machine_id)
            ->update([
                'Active' => $recv['Active'],
            ]);
        return json_encode(TRUE);
    }
}
