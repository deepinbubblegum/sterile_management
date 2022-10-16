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

class Users_Controller extends BaseController
{
    public function getAllUsers(Request $request)
    {
        try {

            $data = $request->all();
            $return_data = new \stdClass();

            $users = DB::table('users')
                ->select('users.User_id', 'users.Username', 'groups.Group_name', 'groups.Group_id', 'users.Activate', 'users.Name')
                ->leftjoin('groups', 'users.Group_id', '=', 'groups.Group_id')
                ->where(function ($query) use ($data) {
                    if (isset($data['txt_search'])) {
                        $query->where('users.Username', 'like', '%' . $data['txt_search'] . '%')
                            ->orWhere('users.Name', 'like', '%' . $data['txt_search'] . '%');
                    }
                })
                ->orderBy('users.User_id', 'desc')
                ->paginate(8);

            $return_data->users = $users;
            return $return_data;

        } catch (Exception $e) {

            $return_data = new \stdClass();

            $return_data->code = '000000';
            $return_data->message =  $e->getMessage();

            return $return_data;
        }
    }

    public function delUser(Request $request)
    {
        $recv = $request->all();
        $id = $recv['id'];
        DB::table('users')->where('User_id', $id)->delete();
        return json_encode('success');
    }

    public function setActivate(Request $request)
    {
        $recv = $request->all();
        $id = $recv['id'];
        $activate = $recv['activate'];
        DB::table('users')->where('User_id', $id)->update(['Activate' => $activate]);
        return json_encode('success');
    }

    public function getGroup(Request $request)
    {
        $recv = $request->all();
        $group = DB::table('groups')->get();
        return json_encode($group);
    }

    private function autoIdUsers()
    {
        $uid = DB::select(
            'SELECT CONCAT("UID-",LPAD(SUBSTRING(IFNULL(MAX(users.User_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM users'
        );
        return $uid[0]->auto_id;
    }
    
    public function createUsers(Request $request)
    {
        $recv = $request->all();
        $username = $recv['username'];
        $password = $recv['password'];
        $name = $recv['name'];
        $group_id = $recv['group'];
        $email = $recv['email'];
        $user_id = $this->autoIdUsers();
        $password = Hash::make($password);
        // dd($password);
        DB::table('users')->insert([
            'User_id' => $user_id,
            'Username' => $username,
            'Password' => $password,
            'Name' => $name,
            'Group_id' => $group_id,
            'Email' => $email,
            'Activate' => 1,
            'Image' => NULL,
            'CreateDate' => Carbon::now(),
        ]);
        return json_encode('success');
    }

    public function getUsersDetail(Request $request)
    {
        $recv = $request->all();
        $id = $recv['id'];
        $user = DB::table('users')->where('User_id', $id)->first();
        return json_encode($user);
    }

    public function updateUsers(Request $request)
    {
        $recv = $request->all();
        $username = $recv['username'];
        $password = $recv['password'];
        $name = $recv['name'];
        $group_id = $recv['group_id'];
        $email = $recv['email'];
        $user_id = $recv['user_id'];
        $password = Hash::make($password);
        DB::table('users')->where('User_id', $user_id)->update([
            'Username' => $username,
            'Password' => $password,
            'Name' => $name,
            'Group_id' => $group_id,
            'Email' => $email,
        ]);
        return json_encode('success');
    }
}
