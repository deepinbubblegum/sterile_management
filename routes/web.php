<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Http\Controllers\Login_Controller;
use App\Http\Controllers\Order_Controller;
use App\Http\Controllers\Process_Controller;
use App\Http\Controllers\OnProcess_controller;
use App\Http\Controllers\CreateOrder_Controller;
use App\Http\Controllers\Customers_Controller;
use App\Http\Controllers\Departments_Controller;
use App\Http\Controllers\DeptEquip_Controller;
use App\Http\Controllers\Equipments_Controller;
use App\Http\Controllers\Users_Controller;

use App\Http\Controllers\Pro_Washing_Controller;
use App\Http\Controllers\Pro_Packing_Controller;
use App\Http\Controllers\Pro_Sterile_Controller;

use App\Http\Controllers\Stock_Controller;
use App\Http\Controllers\StockList_Controller;
use App\Http\Controllers\Stock_Deliver_Controller;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    // return view('login');
    if (Cookie::get('Username_server') != null) {
        // dd(Cookie::get('SMS_Username_server'));
        return redirect()->route('welcome');
    } else {
        Cookie::queue(Cookie::forget('Username_server'));
        return view('login');
    }
})->name('login');

Route::get('/logout', function () {
    Cookie::queue(Cookie::forget('Username_server'));
    Cookie::queue(Cookie::forget('Username_server_Permission'));
    return redirect()->route('login');
})->name('logout');


Route::post('/Login_user', [Login_Controller::class, 'Login_user']);


Route::group(['middleware' => ['authLogin']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');


    Route::get('/process', function () {
        return view('process');
    });

    Route::post('/process/GetOder', [Process_Controller::class, 'GetListOder']);

    Route::get('/Onprocess/{oder_id}', function ($oder_id) {
        // dd($oder_id);
        return view('Onprocess', ['oder_id' => $oder_id]);
    });

    Route::post('/Onprocess/GetOderItem', [OnProcess_controller::class, 'OnProcess_GetOderItem']);

    // Process Washing
    Route::post('/Onprocess/GetWashing_machine', [Pro_Washing_Controller::class, 'OnProcess_GetWashing_machine']);
    Route::post('/Onprocess/GetWashing_List', [Pro_Washing_Controller::class, 'OnProcess_GetWashing_List']);
    Route::post('/Onprocess/New_WashingList', [Pro_Washing_Controller::class, 'OnProcess_Washing_newItem']);

    // Process Packing
    Route::post('/Onprocess/Getsterile_machine', [Pro_Packing_Controller::class, 'OnProcess_Getsterile_machine']);
    Route::post('/Onprocess/GetPacking_List', [Pro_Packing_Controller::class, 'OnProcess_GetPacking_List']);
    Route::post('/Onprocess/GetUserQC', [Pro_Packing_Controller::class, 'OnProcess_GetUserQC']);
    Route::post('/Onprocess/New_PackingList', [Pro_Packing_Controller::class, 'OnProcess_New_PackingList']);

    Route::post('/Onprocess/New_ImagePacking', [Pro_Packing_Controller::class, 'OnProcess_New_ImagePacking']);
    Route::post('/Onprocess/GetPacking_Img_list', [Pro_Packing_Controller::class, 'OnProcess_GetPacking_Img_list']);
    Route::post('/Onprocess/Delete_Img_list', [Pro_Packing_Controller::class, 'OnProcess_Delete_Img_list']);

    Route::get('/Onprocess/pdf/{oder_id}', [Pro_Packing_Controller::class, 'getPackingPDF']);
    Route::get('/Onprocess/pdf/{oder_id}/{item_id}', [Pro_Packing_Controller::class, 'getPackingPDF']);


    // Process sterile
    Route::post('/Onprocess/Getsterile_List', [Pro_Sterile_Controller::class, 'OnProcess_Getsterile_List']);
    Route::post('/Onprocess/New_sterileList', [Pro_Sterile_Controller::class, 'OnProcess_New_sterileList']);
    Route::post('/Onprocess/New_ImageSterile', [Pro_Sterile_Controller::class, 'OnProcess_New_ImageSterile']);
    Route::post('/Onprocess/GetSterile_Img_list', [Pro_Sterile_Controller::class, 'OnProcess_GetSterile_Img_list']);
    Route::post('/Onprocess/Delete_Img_list_Sterile', [Pro_Sterile_Controller::class, 'Delete_Img_list_Sterile']);



    // Stock
    Route::get('/stock', function () {
        return view('stock');
    });
    Route::post('/Get_Stock', [Stock_Controller::class, 'Get_Stock']);
    Route::get('/stock/{oder_id}', function ($oder_id) {
        return view('stockList', ['oder_id' => $oder_id]);
    });
    Route::post('/stock/GetStockItem', [StockList_Controller::class, 'Get_StockList_Item']);



    // Deliver
    Route::get('/stock/deliver_pdf/{oder_id}', [Stock_Deliver_Controller::class, 'Deliver_pdf']);



    // Create Order Page use here
    Route::get('/orders/create', function () {
        return view('createOrders');
    });
    Route::get('/orders/create/getcustomers', [CreateOrder_Controller::class, 'getCustomers']);
    Route::get('/orders/create/getdepartments', [CreateOrder_Controller::class, 'getDepartments']);
    Route::get('/orders/create/getequipments', [CreateOrder_Controller::class, 'getEquipments']);
    Route::get('/orders/create/getsituations', [CreateOrder_Controller::class, 'getSituations']);
    Route::post('/orders/create/createorders', [CreateOrder_Controller::class, 'createOrders']);
    Route::get('/orders/create/getequipimages', [CreateOrder_Controller::class, 'getEquipImages']);

    // Edit Order Page use here
    Route::get('/orders/edit/{order_id}', function () {
        return view('editOrders');
    });
    // Route::get('/orders/edit/{order_id}/getorders', [Order_Controller::class, 'getOrders']);

    // Order Page use here
    Route::get('/orders', function () {
        return view('orders');
    });
    Route::get('/orders/getlistorder', [Order_Controller::class, 'getListOrder']);
    Route::get('/orders/pdf', [Order_Controller::class, 'getOrderPDF']);
    Route::post('/orders/delOrder', [Order_Controller::class, 'delOrder']);
    Route::post('/orders/approveOrder', [Order_Controller::class, 'approveOrder']);

    // Settings Customer Page use here
    Route::get('/settings/customers', function () {
        return view('customers');
    });
    Route::get('/settings/customers/getlistcustomers', [Customers_Controller::class, 'getListCustomers']);
    Route::get('/settings/customers/getcustomersdetail', [Customers_Controller::class, 'getCustomersDetail']);
    Route::post('/settings/customers/createcustomers', [Customers_Controller::class, 'createCustomers']);
    Route::post('/settings/customers/updatecustomers', [Customers_Controller::class, 'updateCustomers']);
    Route::post('/settings/customers/deletecustomers', [Customers_Controller::class, 'deleteCustomers']);

    // Settings Department Page use here
    Route::get('/settings/customers/departments/{customer_id}', function () {
        return view('departments');
    });
    Route::get('/settings/customers/departments/{customer_id}/getlistdepartments', [Departments_Controller::class, 'getListDepartments']);
    Route::get('/settings/customers/departments/{customer_id}/getdepartmentsdetail', [Departments_Controller::class, 'getDepartmentsDetail']);
    Route::post('/settings/customers/departments/{customer_id}/createdepartments', [Departments_Controller::class, 'createDepartments']);
    Route::post('/settings/customers/departments/{customer_id}/updatedepartments', [Departments_Controller::class, 'updateDepartments']);
    Route::post('/settings/customers/departments/{customer_id}/deletedepartments', [Departments_Controller::class, 'deleteDepartments']);

    // Settings Equipment in Department Page use here
    Route::get('/settings/customers/departments/{customer_id}/{department_id}', [DeptEquip_Controller::class, 'viewDeptEquip']);
    Route::get('/settings/customers/departments/{customer_id}/{department_id}/getlistequip', [DeptEquip_Controller::class, 'getlistequip']);
    Route::get('/settings/customers/departments/{customer_id}/{department_id}/getlistdeptequip', [DeptEquip_Controller::class, 'getListDeptEquip']);
    Route::post('/settings/customers/departments/{customer_id}/{department_id}/adddeptequip', [DeptEquip_Controller::class, 'addDeptEquip']);
    Route::post('/settings/customers/departments/{customer_id}/{department_id}/deletedeptequip', [DeptEquip_Controller::class, 'deleteDeptEquip']);

    // Settings Equipments Page use here
    Route::get('/settings/equipments', function () {
        return view('equipments');
    });
    Route::get('/settings/equipments/getlistequipments', [Equipments_Controller::class, 'getListEquipments']);
    Route::get('/settings/equipments/getequipmentsdetail', [Equipments_Controller::class, 'getEquipmentsDetail']);
    Route::post('/settings/equipments/createequipments', [Equipments_Controller::class, 'createEquipments']);
    Route::post('/settings/equipments/updateequipments', [Equipments_Controller::class, 'updateEquipments']);
    Route::post('/settings/equipments/deleteequipments', [Equipments_Controller::class, 'deleteEquipments']);
    Route::post('/settings/equipments/activateequipments', [Equipments_Controller::class, 'activateEquipments']);

    // Settings Users Page use here
    Route::get('/settings/users', function () {
        return view('users');
    });
    Route::get('/settings/getgroup', [Users_Controller::class, 'getGroup']);
    Route::get('/settings/users/getallusers', [Users_Controller::class, 'getAllUsers']);
    Route::get('/settings/users/getusersdetail', [Users_Controller::class, 'getUsersDetail']);
    Route::post('/settings/users/deleteusers', [Users_Controller::class, 'delUser']);
    Route::post('/settings/users/toggleactivateusers', [Users_Controller::class, 'setActivate']);
    Route::post('/settings/users/createusers', [Users_Controller::class, 'createUsers']);
    Route::post('/settings/users/editusers', [Users_Controller::class, 'updateUsers']);

});

Route::get('/logout', function () {
    Cookie::queue(Cookie::forget('Username_server'));
    Cookie::queue(Cookie::forget('Username_server_Permission'));
    return redirect()->route('login');
})->name('logout');

// Route::get('/process', function () {
//     return view('process');
// });
