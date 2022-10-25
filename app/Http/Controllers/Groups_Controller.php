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

    private function getPermissions()
    {
        $permissions = DB::table('permissions')
            ->select('permissions.Permission_ID')
            ->get();
        return $permissions;
    }

    private function AtuoIdGroup()
    {
        $gup = DB::select(
            'SELECT CONCAT("GUP-",LPAD(SUBSTRING(IFNULL(MAX(groups.Group_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM groups'
        );
        return $gup[0]->auto_id;
    }

    public function createGroups(Request $request)
    {
        $permissions = $this->getPermissions();
        $recv = $request->all();
        $group_name = $recv['group_name'];
        $group_id = $this->AtuoIdGroup();
        $group = DB::table('groups')->insert([
            'Group_id' => $group_id,
            'Group_name' => $group_name
        ]);

        foreach ($permissions as $key => $value) {
            $group_permission = DB::table('permissions_group')->insert([
                'Group_id' => $group_id,
                'Permission_id' => $value->Permission_ID,
                'Active' => 0
            ]);
        }
        return json_encode(TRUE);
    }

    public function getGroupsDetail(Request $request)
    {
        $recv = $request->all();
        $group_id = $recv['group_id'];
        $group = DB::table('groups')
            ->select('groups.*')
            ->where('groups.Group_id', $group_id)
            ->first();
        return $group;
    }

    public function updateGroups(Request $request)
    {
        $recv = $request->all();
        $group_id = $recv['group_id'];
        $group_name = $recv['group_name'];
        $group = DB::table('groups')
            ->where('groups.Group_id', $group_id)
            ->update([
                'Group_name' => $group_name
            ]);
        return json_encode(TRUE);
    }

    public function deleteGroups(Request $request)
    {
        $recv = $request->all();
        $group_id = $recv['group_id'];
        $group = DB::table('groups')
            ->where('Group_id', $group_id)
            ->delete();
        return json_encode(TRUE);
    }

    public function getPermissionsGroup(Request $request)
    {
        $recv = $request->all();
        $group_id = $recv['group_id'];
        $permissions = DB::table('permissions_group')
            ->select('permissions_group.*', 'permissions.Permission_Allow')
            ->leftjoin('permissions', 'permissions.Permission_ID', '=', 'permissions_group.Permission_id')
            ->where('permissions_group.Group_id', $group_id)
            ->get();
        return $permissions;
    }

    public function updatePermissionsGroup(Request $request)
    {
        $recv = $request->all();
        $permissions = $recv['permissions'];
        foreach ($permissions as $key => $value) {
            $group_permission = DB::table('permissions_group')
                ->where('Group_ID', $value['group_id'])
                ->where('Permission_ID', $value['permission_id'])
                ->update([
                    'Active' => $value['active']
                ]);
        }
        return json_encode(TRUE);
    }
}
