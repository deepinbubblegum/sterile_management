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

class MachinesWashings_Controller extends BaseController
{
    public function getListMachinesWashings(Request $request){
        try {
            $return_data = new \stdClass();
            $data = $request->all();
            $machines = DB::table('machineswashing')
                ->select('machineswashing.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('machineswashing.MachinesWashingName', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('MachinesWashing_id', 'desc')
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

    public function getMachinesWashingsDetail(Request $request)
    {
        $recv = $request->all();
        $machines = DB::table('machineswashing')
            ->select('machineswashing.*')
            ->where('machineswashing.MachinesWashing_id', $recv['machine_id'])
            ->first();
        return $machines;
    }

    private function AutoMachineWashingsID()
    {
        $WASH = DB::select(
            'SELECT CONCAT("WASH-",LPAD(SUBSTRING(IFNULL(MAX(machineswashing.MachinesWashing_id), "0"), 6,7)+1, 5,"0")) as auto_id FROM machineswashing'
        );
        return $WASH[0]->auto_id;
    }

    public function createMachinesWashings(Request $request)
    {
        $recv = $request->all();
        $machines = DB::table('machineswashing')
            ->insert([
                'MachinesWashing_id' => $this->AutoMachineWashingsID(),
                'MachinesWashingName' => $recv['machine_name'],
            ]);
        return $machines;
    }

    public function deleteMachinesWashings(Request $request)
    {
        $recv = $request->all();
        $machines = DB::table('machineswashing')
            ->where('machineswashing.MachinesWashing_id', $recv['machine_id'])
            ->delete();
        return $machines;
    }

    public function updateMachinesWashings(Request $request)
    {
        $recv = $request->all();
        $machines = DB::table('machineswashing')
            ->where('machineswashing.MachinesWashing_id', $recv['machine_id'])
            ->update([
                'MachinesWashingName' => $recv['machine_name'],
            ]);
        return $machines;
    }
}
