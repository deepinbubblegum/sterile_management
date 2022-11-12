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
use App\Http\Controllers\UsersPermission_Controller;

class EditOrder_Controller extends BaseController
{

    public function getOrder(Request $request)
    {
        $recv = $request->all();
        $order_id = $recv['order_id'];
        $order_detail = DB::table('orders')
            ->select('orders.Order_id', 'orders.Customer_id', 'orders.Department_id', 'orders.Notes')
            ->where('orders.Order_id', $order_id)
            ->first();
        return $order_detail;
    }

    public function getitemslist(Request $request)
    {
        $recv = $request->all();
        $order_id = $recv['order_id'];
        $itemslist = DB::table('items')
            ->select('orders.Order_id', 'items.Item_id', 'equipments.Equipment_id', 'equipments.Name', 'equipments.Process', 'equipments.Price', 'items.Situation_id', 'situations.Situation_name', 'items.Quantity', 'items.Item_status')
            ->leftJoin('orders', 'items.Order_id', '=', 'orders.Order_id')
            ->leftJoin('equipments', 'equipments.Equipment_id', '=', 'items.Equipment_id')
            ->leftJoin('situations', 'items.Situation_id', '=', 'situations.Situation_id')
            ->where('orders.Order_id', '=', $order_id)
            ->get();
        return $itemslist;
    }

    private function getAutoItemsID()
    {
        $itm = DB::select(
            'SELECT CONCAT("ITM-",LPAD(SUBSTRING(IFNULL(MAX(items.Item_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM items'
        );
        return $itm[0]->auto_id;
    }

    private function AutoIDImage()
    {
        $itm = DB::select(
            'SELECT CONCAT("IMG_ODI-",LPAD(SUBSTRING(IFNULL(MAX(order_image.Image_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM order_image'
        );
        return $itm[0]->auto_id;
    }

    private function getAutoNotificationID()
    {
        $itm = DB::select(
            'SELECT CONCAT("NOT-",LPAD(SUBSTRING(IFNULL(MAX(notifications.notifications_id), "0"), 5,6)+1, 6,"0")) as auto_id FROM notifications'
        );
        return $itm[0]->auto_id;
    }

    private function getAutoSub_NotificationID()
    {
        $itm = DB::select(
            'SELECT CONCAT("SUB_NOT-",LPAD(SUBSTRING(IFNULL(MAX(noti_detail.sub_noti_id), "0"), 9,6)+1, 6,"0")) as auto_id FROM noti_detail'
        );
        return $itm[0]->auto_id;
    }

    public function editOrder(Request $request)
    {
        try {
            $recv = $request->all();
            $order_id = $recv['order_id'];
            if (isset($recv['file'])) {
                $images = $request->file('file');
            }
            $_notes_messages = $recv['notes_messages'];
            $_cutomers_id = $recv['customers_id'];
            $_departments_id = $recv['departments_id'];
            $_items = json_decode($recv['items'], true);
            $user_id = $request->cookie('Username_server_User_id');
            $delete_data = json_decode($recv['delete_data']);
            $delete_images = json_decode($recv['delete_images']);
            $delete_images_id = json_decode($recv['delete_images_id']);


            $NotificationID = $this->getAutoNotificationID();
            DB::table('notifications')->insert([
                'notifications_id' => $NotificationID,
                'notifications_from' => $user_id,
                'notifications_to' => $_departments_id,
                'notifications_readed' => '0',
                'Create_at' => Carbon::now(),
                'Order_id' => $order_id,
            ]);

            if (count($delete_data) > 0) {
                foreach ($delete_data as $key => $value) {

                    $items_detail = DB::table('items')
                        ->select('*')
                        ->where('Item_id', $value)
                        ->first();

                    DB::table('noti_detail')->insert([
                        'notifications_id' => $NotificationID,
                        'sub_noti_id' => $this->getAutoSub_NotificationID(),
                        'Action' => 'Delete',
                        'Item_id' => null,
                        'Equipment_id' => $items_detail->Equipment_id,
                        'Situation_id_from' => null,
                        'Situation_id_to' => null,
                        'Quantity_from' => null,
                        'Quantity_to' => null,
                    ]);

                    DB::table('items')
                        ->where('Item_id', $value)
                        ->delete();
                }
            }

            DB::table('orders')->where('Order_id', $order_id)
                ->update([
                    'Notes' => $_notes_messages,
                    'Update_by' => $user_id,
                    'Update_at' => Carbon::now(),
                ]);

            foreach ($_items as $key => $value) {
                if ($value['item_id'] == null) {
                    $item_id = $this->getAutoItemsID();
                    DB::table('items')->insert([
                        'Item_id' => $item_id,
                        'Order_id' => $order_id,
                        'Equipment_id' => $value['equipment_id'],
                        'Situation_id' => $value['situation'],
                        'Quantity' => $value['qty'],
                        'Item_status' => null,
                    ]);

                    DB::table('noti_detail')->insert([
                        'notifications_id' => $NotificationID,
                        'sub_noti_id' => $this->getAutoSub_NotificationID(),
                        'Action' => 'Add',
                        'Item_id' => $item_id,
                        'Equipment_id' => $value['equipment_id'],
                        'Situation_id_from' => $value['situation'],
                        'Situation_id_to' => null,
                        'Quantity_from' => $value['qty'],
                        'Quantity_to' => null,
                    ]);
                } else {

                    $items_detail = DB::table('items')
                        ->select('*')
                        ->where('Item_id', $value)
                        ->first();

                    if ($items_detail->Situation_id != $value['situation'] || $items_detail->Quantity != $value['qty']) {
                        DB::table('noti_detail')->insert([
                            'notifications_id' => $NotificationID,
                            'sub_noti_id' => $this->getAutoSub_NotificationID(),
                            'Action' => 'Edit',
                            'Item_id' => $value['item_id'],
                            'Equipment_id' => $value['equipment_id'],
                            'Situation_id_from' => $items_detail->Situation_id != $value['situation'] ? $items_detail->Situation_id : null,
                            'Situation_id_to' => $items_detail->Situation_id != $value['situation'] ? $value['situation'] : null,
                            'Quantity_from' => $items_detail->Quantity != $value['qty'] ? $items_detail->Quantity : null,
                            'Quantity_to' => $items_detail->Quantity != $value['qty'] ? $value['qty'] : null,
                        ]);
                    }

                    DB::table('items')->where('Item_id', $value['item_id'])
                        ->update([
                            'Situation_id' => $value['situation'],
                            'Quantity' => $value['qty'],
                        ]);
                }
            }

            foreach ($delete_images_id as $key => $value) {
                DB::table('order_image')
                    ->where('Image_id', $value)
                    ->delete();
            }

            foreach ($delete_images as $key => $value) {
                $path = public_path('assets/image/orders/' . $value);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            if (isset($recv['file'])) {
                foreach ($images as $image) {
                    $image_id = $this->AutoIDImage();
                    $image_name = $image_id . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('assets/image/orders'), $image_name);
                    DB::table('order_image')->insert([
                        'Image_id' => $image_id,
                        'Order_id' => $order_id,
                        'Image_name' => $image_name,
                    ]);
                }
            }

            $check_noti = DB::table('noti_detail')
                ->select('*')
                ->where('notifications_id', $NotificationID)
                ->count();

            if ($check_noti == 0) {
                DB::table('notifications')
                    ->where('notifications_id', $NotificationID)
                    ->delete();
            }
        } catch (Exception $e) {
            // return json_decode(FALSE);
            return $e->getMessage();
        }
        return json_decode(TRUE);
    }

    public function getItemsImages(Request $request)
    {
        $recv = $request->all();
        $order_id = $recv['order_id'];
        $order_image = DB::table('order_image')
            ->select('*')
            ->where('Order_id', '=', $order_id)
            ->get();
        return $order_image;
    }

    public function approveOrder(Request $request)
    {
        $recv = $request->all();
        $order_id = $recv['order_id'];
        $current = Carbon::now();
        $approve_by = $request->cookie('Username_server_User_id');
        DB::table('orders')->where('Order_id', $order_id)
            ->update([
                'Approve_by' => $approve_by,
                'StatusApprove' => 1,
                'Approve_at' => $current
            ]);
        return json_decode(TRUE);
    }
}