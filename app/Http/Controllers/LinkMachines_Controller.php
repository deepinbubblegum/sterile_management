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

class LinkMachines_Controller extends BaseController
{
    public function getListPrograme(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();
            $machine_id = $request->machine_id;
            $listPrograme = DB::table('machine_programs')
                ->select('machine_programs.*', 'programs.Program_name')
                ->leftjoin('programs', 'machine_programs.Program_id', '=', 'programs.Program_id')
                ->where('machine_programs.Machine_id', $machine_id)
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('Program_name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('machine_programs.Program_id', 'desc')
                ->paginate(8);
            
            $return_data->listPrograme = $listPrograme;
            return $return_data;
        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function deleteLinkPrograme(Request $request)
    {
        $recv = $request->all();
        $machine_id = $request->machine_id;
        $program_id = $recv['program_id'];
        DB::table('machine_programs')
            ->where('Machine_id', $machine_id)
            ->where('Program_id', $program_id)
            ->delete();
        return json_encode(true);
    }
    
    public function getPrograme(Request $request)
    {
        $machine_id = $request->machine_id;
        $listPrograme = DB::table('programs')
            ->select('*')
            ->whereNotIn('programs.Program_id',(function ($query) use ($machine_id) {
                $query->from('machine_programs')
                    ->select('machine_programs.Program_id')
                    ->where('machine_programs.Machine_id','=', $machine_id);
            }))
            ->get();
        return $listPrograme;
    }

    public function addLinkPrograme(Request $request)
    {
        $recv = $request->all();
        $machine_id = $request->machine_id;
        $program_id = $recv['program_id'];
        $data = array(
            'Machine_id' => $machine_id,
            'Program_id' => $program_id,
        );
        DB::table('machine_programs')->insert($data);
        return json_encode(TRUE);
    }
}
