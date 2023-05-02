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

class Notifications_Controller extends BaseController
{
    public function getNotifications(Request $request)
    {
        $recv = $request->all();

        $user_id = Cookie::get('Username_server_User_id');
        $notifications = DB::table('notifications')
        ->select('notifications.notifications_id', 'notifications.notifications_from', 'notifications.notifications_to', 'notifications.notifications_readed', 'notifications.Create_at', 'notifications.Order_id', 'users.Name', 'departments.Department_name')
        ->leftJoin('users','notifications.notifications_from','=','users.User_id')
        ->leftJoin('departments','notifications.notifications_to','=','departments.Department_id')
        ->whereIn('notifications.notifications_to',(function ($query) use ($user_id) {
            $query->from('users')
                ->select('usersdepartments.Department_id')
                ->leftJoin('usersdepartments','users.User_id','=','usersdepartments.User_id')
                ->where('users.User_id','=', $user_id);
        }))
        ->get();
        // $notifications
        return response()->json($notifications);
    }

    public function getNotificationEditOrderDetail(Request $request)
    {
        $recv = $request->all();
        $notifications_id = $recv['noti_id'];
        $notifications = DB::select("
        SELECT 
            noti_detail.notifications_id,
            noti_detail.Action,
            noti_detail.Equipment_id,
            equipments.Name,
            situation_from.Situation_name as situation_from,
            situation_to.Situation_name as situation_to,
            noti_detail.Quantity_from,
            noti_detail.Quantity_to
        FROM noti_detail
        LEFT JOIN equipments ON noti_detail.Equipment_id = equipments.Equipment_id
        LEFT JOIN situations as situation_from ON noti_detail.Situation_id_from = situation_from.Situation_id 
        LEFT JOIN situations as situation_to ON noti_detail.Situation_id_to = situation_to.Situation_id
        WHERE noti_detail.notifications_id = ?
        ",[$notifications_id]);

        return response()->json($notifications);
    }

    public function NotificationReaded(Request $request)
    {
        $recv = $request->all();
        $notifications_id = $recv['noti_id'];
        $notifications = DB::table('notifications')
        ->where('notifications_id', $notifications_id)
        ->update(['notifications_readed' => 1]);
        return response()->json($notifications);
    }
}