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

class Programs_Controller extends BaseController
{
    public function getListPrograms(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();
            $programs = DB::table('programs')
                ->select('programs.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('programs.Program_name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('program_id', 'desc')
                ->paginate(8);
            
            $return_data->programs = $programs;
            return $return_data;

        } catch (\Throwable $th) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $th->getMessage();

            return $return_data;
        }
    }

    private function autoIdProgram()
    {
        $pid = DB::select(
            'SELECT CONCAT("PRG-",LPAD(SUBSTRING(IFNULL(MAX(programs.Program_id), "0"), 5,6)+1, 4,"0")) as auto_id FROM programs'
        );
        return $pid[0]->auto_id;
    }

    public function createPrograms(Request $request)
    {
        $recv = $request->all();
        $program_id = $this->autoIdProgram();
        $program_name = $recv['program_name'];
        $program = DB::table('programs')
            ->insert([
                'Program_id' => $program_id,
                'Program_name' => $program_name,
            ]);
        return $program;
    }

    public function deletePrograms(Request $request)
    {
        $recv = $request->all();
        $program_id = $recv['program_id'];
        $program = DB::table('programs')
            ->where('Program_id', $program_id)
            ->delete();
        return $program;
    }

    public function updatePrograms(Request $request)
    {
        $recv = $request->all();
        $program_id = $recv['program_id'];
        $program_name = $recv['program_name'];
        $program = DB::table('programs')
            ->where('Program_id', $program_id)
            ->update([
                'Program_name' => $program_name,
            ]);
        return $program;
    }

    public function getProgramsDetail(Request $request)
    {
        $recv = $request->all();
        $program_id = $recv['program_id'];
        $program = DB::table('programs')
            ->where('Program_id', $program_id)
            ->first();
        return $program;
    }
}
