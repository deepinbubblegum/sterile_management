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

class Login_Controller extends BaseController
{

    public function Login_user(Request $request)
    {
        try {

            $data = $request->all();
            $return_data = new \stdClass();

            // $hash_pass = Hash::make($data['password']);

            $users = DB::table('users')
                ->select('Username', 'Password')
                ->where('Username', $data['Username'])
                ->get();
            // dd($users[0]->Password);


            $minutes = time() + 60 * 60 * 6;
            if(Hash::check($data['password'], $users[0]->Password)){


                Cookie::queue('Username_server', $data['Username'], $minutes);
                Cookie::queue('Username_server_Permission', 'admin', $minutes);

                $return_data->code = '200';

            }else{

                $return_data->code = '401';

            }

            return $return_data;

        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }
}
