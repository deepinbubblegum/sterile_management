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

class UsersPermission_Controller extends BaseController
{
    public function UserPermit()
    {
        $user_id = Cookie::get('Username_server_User_id');
        $user_permit = DB::select('
            SELECT permit_group.User_id, permit_group.Name, permit_group.Group_id, permit_group.Group_name,
            MAX(CASE WHEN permit_group.Permission_Allow = "Orders" THEN permit_group.Active END) "Orders",
            MAX(CASE WHEN permit_group.Permission_Allow = "Process" THEN permit_group.Active END) "Process",
            MAX(CASE WHEN permit_group.Permission_Allow = "Stock" THEN permit_group.Active END) "Stock",
            MAX(CASE WHEN permit_group.Permission_Allow = "Reports" THEN permit_group.Active END) "Reports",
            MAX(CASE WHEN permit_group.Permission_Allow = "All Department" THEN permit_group.Active END) "All Department",
            MAX(CASE WHEN permit_group.Permission_Allow = "Settings" THEN permit_group.Active END) "Settings",
            MAX(CASE WHEN permit_group.Permission_Allow = "Customers" THEN permit_group.Active END) "Customers",
            MAX(CASE WHEN permit_group.Permission_Allow = "Equipments" THEN permit_group.Active END) "Equipments",
            MAX(CASE WHEN permit_group.Permission_Allow = "Machines Washings" THEN permit_group.Active END) "Machines Washings",
            MAX(CASE WHEN permit_group.Permission_Allow = "Machines Sterlie" THEN permit_group.Active END) "Machines Sterlie",
            MAX(CASE WHEN permit_group.Permission_Allow = "Programs Sterlie" THEN permit_group.Active END) "Programs Sterlie",
            MAX(CASE WHEN permit_group.Permission_Allow = "Groups" THEN permit_group.Active END) "Groups",
            MAX(CASE WHEN permit_group.Permission_Allow = "Users" THEN permit_group.Active END) "Users",
            MAX(CASE WHEN permit_group.Permission_Allow = "All Orders" THEN permit_group.Active END) "All Orders",
            MAX(CASE WHEN permit_group.Permission_Allow = "Receive Orders" THEN permit_group.Active END) "Receive Orders"
            FROM (
                SELECT users.User_id, users.Name, groups.Group_id, groups.Group_name, permissions.Permission_Allow, permissions_group.Active
                FROM users
                LEFT JOIN groups ON users.Group_id = groups.Group_id
                LEFT JOIN permissions_group ON groups.Group_id = permissions_group.Group_ID
                LEFT JOIN permissions ON permissions_group.Permission_ID = permissions.Permission_ID
                WHERE users.User_id = ?
            ) as permit_group
            GROUP BY permit_group.User_id, permit_group.Name
            ORDER BY permit_group.User_id, permit_group.Name ASC;
        ', [$user_id])[0];
        return $user_permit;
    }
}
