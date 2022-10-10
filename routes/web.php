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

use App\Http\Controllers\Pro_Washing_Controller;
use App\Http\Controllers\Pro_Packing_Controller;


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
    Route::post('/Onprocess/GetSterlie_machine', [Pro_Packing_Controller::class, 'OnProcess_GetSterlie_machine']);
    Route::post('/Onprocess/GetPacking_List', [Pro_Packing_Controller::class, 'OnProcess_GetPacking_List']);
    Route::post('/Onprocess/GetUserQC', [Pro_Packing_Controller::class, 'OnProcess_GetUserQC']);
    Route::post('/Onprocess/New_PackingList', [Pro_Packing_Controller::class, 'OnProcess_New_PackingList']);



    // Create Order Page use here
    Route::get('/orders/create', function () {
        return view('createOrders');
    });
    Route::get('/orders/create/getcustomers', [CreateOrder_Controller::class, 'getCustomers']);
    Route::get('/orders/create/getdepartments', [CreateOrder_Controller::class, 'getDepartments']);
    Route::get('/orders/create/getequipments', [CreateOrder_Controller::class, 'getEquipments']);
    Route::get('/orders/create/getsituations', [CreateOrder_Controller::class, 'getSituations']);
    Route::post('/orders/create/createorders', [CreateOrder_Controller::class, 'createOrders']);

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
    // Route::get('/settings/customers/departments/{customer_id}/{department_id}', function () {
    //     return view('deptequip');
    // });
    Route::get('/settings/customers/departments/{customer_id}/{department_id}', [DeptEquip_Controller::class, 'viewDeptEquip']);

    // Settings Equipments Page use here
    Route::get('/settings/equipments', function () {
        return view('equipments');
    });
    Route::get('/settings/equipments/getlistequipments', [Equipments_Controller::class, 'getListEquipments']);
    Route::post('/settings/equipments/createequipments', [Equipments_Controller::class, 'createEquipments']);
});

Route::get('/logout', function () {
    Cookie::queue(Cookie::forget('Username_server'));
    Cookie::queue(Cookie::forget('Username_server_Permission'));
    return redirect()->route('login');
})->name('logout');



// Route::get('/process', function () {
//     return view('process');
// });
