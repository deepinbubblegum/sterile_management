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

class UsersDepartment_Controller extends BaseController
{
    public function UsersDepartment(Request $request, $id)
    {
        $customer_id = $request->customer_id;
        return view('usersdepartment', ['customer_id' => $customer_id]);
    }
}
