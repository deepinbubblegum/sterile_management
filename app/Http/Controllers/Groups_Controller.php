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

class Groups_Controller extends BaseController
{
    public function getListGroups(Request $request)
    {
        try {
            $return_data = new \stdClass();
            $data = $request->all();
            $groups = DB::table('groups')
                ->select('groups.*')
                ->where(function ($query) use ($data) {
                    if ($data['txt_search'] != '') {
                        $query->where('groups.Name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('group_id', 'desc')
                ->paginate(8);
            
            $return_data->groups = $groups;
            return $return_data;

        } catch (\Throwable $th) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $th->getMessage();

            return $return_data;
        }
    }
}
