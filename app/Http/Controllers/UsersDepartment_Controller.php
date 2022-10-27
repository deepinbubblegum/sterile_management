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

    public function getListUsersDepartment(Request $request)
    {
        try {
            $data = $request->all();
            $return_data = new \stdClass();
            $department_id = strtoupper($request->department_id);
            $usersDepartment = DB::table('usersdepartments')
                ->select('users.User_id', 'users.Name', 'groups.Group_name')
                ->leftjoin('users', 'usersdepartments.User_id', '=', 'users.User_id')
                ->leftjoin('groups', 'users.Group_id', '=', 'groups.Group_id')
                ->where('usersdepartments.Department_id', $department_id)
                ->where(function ($query) use ($data) {
                    if (isset($data['txt_search'])) {
                        $query->where('users.Name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('usersdepartments.User_id', 'desc')
                ->paginate(8);
            $return_data->usersDepartment = $usersDepartment;
            return $return_data;
        } catch (Exception $e) {
            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function getUsers(Request $request)
    {
        $data = $request->all();
        $department_id = strtoupper($request->department_id);
        $users = DB::table('users')
            ->select('*')
            ->whereNotIn('users.User_id',(function ($query) use ($department_id) {
                $query->from('usersdepartments')
                    ->select('usersdepartments.User_id')
                    ->where('usersdepartments.Department_id','=', $department_id);
            }))
            ->orderBy('users.User_id', 'desc')
            ->get();
        return $users;
    }

    public function createUsersDepartment(Request $request)
    {
        $data = $request->all();
        $department_id = strtoupper($request->department_id);
        $usersDepartment = DB::table('usersdepartments')
            ->insert([
                'Department_id' => $department_id,
                'User_id' => $data['user_id'],
            ]);
        return json_encode($usersDepartment);
    }

    public function deleteUsersDepartment(Request $request)
    {
        $data = $request->all();
        $department_id = strtoupper($request->department_id);
        $usersDepartment = DB::table('usersdepartments')
            ->where('User_id', $data['user_id'])
            ->where('Department_id', $department_id)
            ->delete();
        return json_encode($usersDepartment);
    }
}
