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
use App\Http\Controllers\Groups_Controller;
use App\Http\Controllers\MachinesSterile_Controller;
use App\Http\Controllers\MachinesWashings_Controller;
use App\Http\Controllers\Programs_Controller;
use App\Http\Controllers\LinkMachines_Controller;
use App\Http\Controllers\UsersDepartment_Controller;

use App\Http\Controllers\Pro_Washing_Controller;
use App\Http\Controllers\Pro_Packing_Controller;
use App\Http\Controllers\Pro_Sterile_Controller;

use App\Http\Controllers\Stock_Controller;
use App\Http\Controllers\StockList_Controller;
use App\Http\Controllers\Stock_Deliver_Controller;
use App\Http\Controllers\UsersPermission_Controller;
use App\Http\Controllers\Reports_Controller;
use App\Http\Controllers\COA_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\EditOrder_Controller;
use App\Http\Controllers\Scan_QR_Code;
use App\Http\Controllers\Notifications_Controller;


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
    Route::post('/dashboard/Get_Data', [Dashboard_Controller::class, 'Get_Data']);
    Route::post('/dashboard/Get_Stock_Exp', [Dashboard_Controller::class, 'Get_Stock_Exp']);

    Route::post('/QR_code/Check_order', [Scan_QR_Code::class, 'Get_order']);


    Route::get('/process', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Process == "1"){
            return view('process');
        }else{
            return abort(404);
        }
    });

    Route::post('/process/GetOder', [Process_Controller::class, 'GetListOder']);

    Route::get('/Onprocess/{oder_id}', function ($oder_id) {
        // dd($oder_id);
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Process == "1"){
            return view('Onprocess', ['oder_id' => $oder_id]);
        }else{
            return abort(404);
        }
    });

    Route::post('/Onprocess/GetOderItem', [OnProcess_controller::class, 'OnProcess_GetOderItem']);

    // Process Washing
    Route::post('/Onprocess/Get_option_washing_performance', [Pro_Washing_Controller::class, 'Get_option_washing_performance']);
    Route::post('/Onprocess/GetWashing_machine', [Pro_Washing_Controller::class, 'OnProcess_GetWashing_machine']);
    Route::post('/Onprocess/GetWashing_List', [Pro_Washing_Controller::class, 'OnProcess_GetWashing_List']);
    Route::post('/Onprocess/New_WashingList', [Pro_Washing_Controller::class, 'OnProcess_Washing_newItem']);
    Route::post('/Onprocess/New_ImageWashing', [Pro_Washing_Controller::class, 'OnProcess_New_ImageWashing']);
    Route::post('/Onprocess/GetWashing_Img_list', [Pro_Washing_Controller::class, 'OnProcess_GetWashing_Img_list']);
    Route::post('/Onprocess/Delete_Img_list_washing', [Pro_Washing_Controller::class, 'OnProcess_Delete_Img_Washing_list']);


    // Process Packing
    Route::post('/Onprocess/Getsterile_machine', [Pro_Packing_Controller::class, 'OnProcess_Getsterile_machine']);
    Route::post('/Onprocess/GetPacking_List', [Pro_Packing_Controller::class, 'OnProcess_GetPacking_List']);
    Route::post('/Onprocess/GetUserQC', [Pro_Packing_Controller::class, 'OnProcess_GetUserQC']);
    Route::post('/Onprocess/New_PackingList', [Pro_Packing_Controller::class, 'OnProcess_New_PackingList']);

    Route::post('/Onprocess/New_ImagePacking', [Pro_Packing_Controller::class, 'OnProcess_New_ImagePacking']);
    Route::post('/Onprocess/GetPacking_Img_list', [Pro_Packing_Controller::class, 'OnProcess_GetPacking_Img_list']);
    Route::post('/Onprocess/Delete_Img_list', [Pro_Packing_Controller::class, 'OnProcess_Delete_Img_list']);

    Route::get('/Onprocess/pdf/{oder_id}', [Pro_Packing_Controller::class, 'getPackingPDF']);
    Route::get('/Onprocess/pdf/{oder_id}/{item_id}/{packing_id}', [Pro_Packing_Controller::class, 'getPackingPDF']);


    // Process sterile
    Route::post('/Onprocess/Getsterile_List', [Pro_Sterile_Controller::class, 'OnProcess_Getsterile_List']);
    Route::post('/Onprocess/New_sterileList', [Pro_Sterile_Controller::class, 'OnProcess_New_sterileList']);
    Route::post('/Onprocess/New_ImageSterile', [Pro_Sterile_Controller::class, 'OnProcess_New_ImageSterile']);
    Route::post('/Onprocess/GetSterile_Img_list', [Pro_Sterile_Controller::class, 'OnProcess_GetSterile_Img_list']);
    Route::post('/Onprocess/Delete_Img_list_Sterile', [Pro_Sterile_Controller::class, 'Delete_Img_list_Sterile']);



    // COA Report
    Route::get('/coa_report', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->{'COA Report'} == "1"){
            return view('coa_report');
        }else{
            return abort(404);
        }
    });
    Route::get('/COA_Report_PDF/{coa_id}', [COA_Controller::class, 'COA_Report_pdf']);
    Route::post('/coa/Get_mechine', [COA_Controller::class, 'Get_machine']);
    Route::post('/coa/Get_User', [COA_Controller::class, 'Get_User']);
    Route::post('/coa/Get_COA', [COA_Controller::class, 'Get_COA']);
    Route::post('/coa/New_COA_report', [COA_Controller::class, 'New_COA_report']);
    Route::post('/coa/Delete_COA', [COA_Controller::class, 'Delete_COA']);


    // Stock
    Route::get('/stock', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Stock == "1"){
            return view('stock');
        }else{
            return abort(404);
        }
    });
    Route::post('/Get_Stock', [Stock_Controller::class, 'Get_Stock']);
    Route::get('/stock/{oder_id}', function ($oder_id) {
        return view('stockList', ['oder_id' => $oder_id]);
    });
    Route::post('/stock/GetStockItem', [StockList_Controller::class, 'Get_StockList_Item']);

    // Deliver
    Route::get('/stock/deliver_pdf/{oder_id}', [Stock_Deliver_Controller::class, 'Deliver_pdf']);
    Route::post('/stock/deliver_pdf/Save_Deliver', [Stock_Deliver_Controller::class, 'Save_Deliver']);
    Route::post('/stock/Get_list_deliver', [Stock_Deliver_Controller::class, 'Get_list_deliver']);




    // Create Order Page use here
    Route::get('/orders/create', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Orders == "1"){
            return view('createOrders');
        }else{
            return abort(404);
        }
    });
    Route::get('/orders/create/getcustomers', [CreateOrder_Controller::class, 'getCustomers']);
    Route::get('/orders/create/getdepartments', [CreateOrder_Controller::class, 'getDepartments']);
    Route::get('/orders/create/getequipments', [CreateOrder_Controller::class, 'getEquipments']);
    Route::get('/orders/create/getsituations', [CreateOrder_Controller::class, 'getSituations']);
    Route::post('/orders/create/createorders', [CreateOrder_Controller::class, 'createOrders']);
    Route::get('/orders/create/getequipimages', [CreateOrder_Controller::class, 'getEquipImages']);

    Route::get('/orders/edit/getorder', [EditOrder_Controller::class, 'getOrder']);
    Route::get('/orders/edit/getitemslist', [EditOrder_Controller::class, 'getitemslist']);
    Route::get('/orders/edit/getitemsimages', [EditOrder_Controller::class, 'getItemsImages']);
    Route::post('/orders/edit/editorder', [EditOrder_Controller::class, 'editOrder']);
    Route::post('/orders/edit/approve', [EditOrder_Controller::class, 'approveOrder']);

    // Edit Order Page use here
    Route::get('/orders/edit/{order_id}', function () {
        return view('editOrders');
    });
    // Route::get('/orders/edit/{order_id}/getorders', [Order_Controller::class, 'getOrders']);

    // Order Page use here
    Route::get('/orders', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Orders == "1"){
            return view('orders');
        }else{
            return abort(404);
        }
    });
    Route::get('/orders/getlistorder', [Order_Controller::class, 'getListOrder']);
    Route::get('/orders/pdf', [Order_Controller::class, 'getOrderPDF']);
    Route::post('/orders/delOrder', [Order_Controller::class, 'delOrder']);
    Route::post('/orders/approveOrder', [Order_Controller::class, 'approveOrder']);

    // Settings Customer Page use here
    Route::get('/settings/customers', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Customers == "1"){
            return view('customers');
        }else{
            return abort(404);
        }
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

    // Settings User Department Page use here
    Route::get('/settings/customers/departments/{customer_id}/users/{department_id}', [UsersDepartment_Controller::class, 'UsersDepartment']);
    Route::get('/settings/customers/departments/{customer_id}/users/{department_id}/getlistusersdepartment', [UsersDepartment_Controller::class, 'getListUsersDepartment']);
    Route::get('/settings/customers/departments/{customer_id}/users/{department_id}/getlistusers', [UsersDepartment_Controller::class, 'getUsers']);
    Route::post('/settings/customers/departments/{customer_id}/users/{department_id}/createusersdepartment', [UsersDepartment_Controller::class, 'createUsersDepartment']);
    Route::post('/settings/customers/departments/{customer_id}/users/{department_id}/deleteusersdepartment', [UsersDepartment_Controller::class, 'deleteUsersDepartment']);

    // Settings Equipment in Department Page use here
    Route::get('/settings/customers/departments/{customer_id}/{department_id}', [DeptEquip_Controller::class, 'viewDeptEquip']);
    Route::get('/settings/customers/departments/{customer_id}/{department_id}/getlistequip', [DeptEquip_Controller::class, 'getlistequip']);
    Route::get('/settings/customers/departments/{customer_id}/{department_id}/getlistdeptequip', [DeptEquip_Controller::class, 'getListDeptEquip']);
    Route::post('/settings/customers/departments/{customer_id}/{department_id}/adddeptequip', [DeptEquip_Controller::class, 'addDeptEquip']);
    Route::post('/settings/customers/departments/{customer_id}/{department_id}/deletedeptequip', [DeptEquip_Controller::class, 'deleteDeptEquip']);

    // Settings Equipments Page use here
    Route::get('/settings/equipments', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Equipments == "1"){
            return view('equipments');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/equipments/getlistequipments', [Equipments_Controller::class, 'getListEquipments']);
    Route::get('/settings/equipments/getequipmentsdetail', [Equipments_Controller::class, 'getEquipmentsDetail']);
    Route::post('/settings/equipments/createequipments', [Equipments_Controller::class, 'createEquipments']);
    Route::post('/settings/equipments/updateequipments', [Equipments_Controller::class, 'updateEquipments']);
    Route::post('/settings/equipments/deleteequipments', [Equipments_Controller::class, 'deleteEquipments']);
    Route::post('/settings/equipments/activateequipments', [Equipments_Controller::class, 'activateEquipments']);
    Route::post('/settings/equipments/imagesuploadequpment', [Equipments_Controller::class, 'imagesUploadEquipment']);
    Route::post('/settings/equipments/deleteimageequpment', [Equipments_Controller::class, 'deleteImageEquipment']);
    Route::get('/settings/equipments/getequipmentsimages', [Equipments_Controller::class, 'getEquipImages']);

    // Settings Users Page use here
    Route::get('/settings/users', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Users == "1"){
            return view('users');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/getgroup', [Users_Controller::class, 'getGroup']);
    Route::get('/settings/users/getallusers', [Users_Controller::class, 'getAllUsers']);
    Route::get('/settings/users/getusersdetail', [Users_Controller::class, 'getUsersDetail']);
    Route::post('/settings/users/deleteusers', [Users_Controller::class, 'delUser']);
    Route::post('/settings/users/toggleactivateusers', [Users_Controller::class, 'setActivate']);
    Route::post('/settings/users/createusers', [Users_Controller::class, 'createUsers']);
    Route::post('/settings/users/editusers', [Users_Controller::class, 'updateUsers']);

    // Settings Groups Page use here
    Route::get('/settings/groups', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Groups == "1"){
            return view('groups');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/groups/getlistgroups', [Groups_Controller::class, 'getListGroups']);
    Route::get('/settings/groups/getgroupsdetail', [Groups_Controller::class, 'getGroupsDetail']);
    Route::post('/settings/groups/creategroups', [Groups_Controller::class, 'createGroups']);
    Route::post('/settings/groups/updategroups', [Groups_Controller::class, 'updateGroups']);
    Route::post('/settings/groups/deletegroups', [Groups_Controller::class, 'deleteGroups']);
    Route::get('/settings/groups/getpermissionsgroup', [Groups_Controller::class, 'getPermissionsGroup']);
    Route::post('/settings/groups/updatepermissionsgroup', [Groups_Controller::class, 'updatePermissionsGroup']);

    // Settings Programes Sterile Page use here
    Route::get('/settings/programs', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->{'Programs Sterlie'} == "1"){
            return view('programs');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/programs/getlistprograms', [Programs_Controller::class, 'getListPrograms']);
    Route::get('/settings/programs/getprogramsdetail', [Programs_Controller::class, 'getProgramsDetail']);
    Route::post('/settings/programs/createprograms', [Programs_Controller::class, 'createPrograms']);
    Route::post('/settings/programs/updateprograms', [Programs_Controller::class, 'updatePrograms']);
    Route::post('/settings/programs/deleteprograms', [Programs_Controller::class, 'deletePrograms']);

    // Settings Machines sterile Page use here
    Route::get('/settings/machinessterile', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->{'Machines Sterlie'} == "1"){
            return view('machinessterile');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/machinessterile/getlistmachines', [MachinesSterile_Controller::class, 'getListMachinesSterile']);
    Route::get('/settings/machinessterile/getmachinesdetail', [MachinesSterile_Controller::class, 'getMachinesSterileDetail']);
    Route::post('/settings/machinessterile/createmachines', [MachinesSterile_Controller::class, 'createMachinesSterile']);
    Route::post('/settings/machinessterile/updatemachines', [MachinesSterile_Controller::class, 'updateMachinesSterile']);
    Route::post('/settings/machinessterile/deletemachines', [MachinesSterile_Controller::class, 'deleteMachinesSterile']);
    Route::post('/settings/machinessterile/activatemachines', [MachinesSterile_Controller::class, 'toggleActivate']);

    // Settings Link Machines Programes Sterile Page use here
    Route::get('/settings/machinessterile/{machine_id}/programes', function () {
        return view('linkmachines');
    });
    Route::get('/settings/machinessterile/{machine_id}/programes/getlistlinkmachines', [LinkMachines_Controller::class, 'getListPrograme']);
    Route::get('/settings/machinessterile/{machine_id}/programes/getprogram', [LinkMachines_Controller::class, 'getPrograme']);
    Route::post('/settings/machinessterile/{machine_id}/programes/deletelink', [LinkMachines_Controller::class, 'deleteLinkPrograme']);
    Route::post('/settings/machinessterile/{machine_id}/programes/addlink', [LinkMachines_Controller::class, 'addLinkPrograme']);


    // Settings Machines washings Page use here
    Route::get('/settings/machineswashings', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->{'Machines Washings'} == "1"){
            return view('machineswashings');
        }else{
            return abort(404);
        }
    });
    Route::get('/settings/machineswashings/getlistmachines', [MachinesWashings_Controller::class, 'getListMachinesWashings']);
    Route::get('/settings/machineswashings/getmachinesdetail', [MachinesWashings_Controller::class, 'getMachinesWashingsDetail']);
    Route::post('/settings/machineswashings/createmachines', [MachinesWashings_Controller::class, 'createMachinesWashings']);
    Route::post('/settings/machineswashings/updatemachines', [MachinesWashings_Controller::class, 'updateMachinesWashings']);
    Route::post('/settings/machineswashings/deletemachines', [MachinesWashings_Controller::class, 'deleteMachinesWashings']);
    Route::post('/settings/machineswashings/activate', [MachinesWashings_Controller::class, 'toggleActive']);

    // Reports Page use here
    Route::get('/reports', function () {
        $users_permit = new UsersPermission_Controller();
        $permissions = $users_permit->UserPermit();
        if ($permissions->Reports == "1"){
            return view('reports');
        }else{
            return abort(404);
        }
    });
    Route::get('/reports/getlistcustomers', [Reports_Controller::class, 'getListCustomers']);
    Route::get('/reports/getlistdepartments', [Reports_Controller::class, 'getListDepartments']);
    Route::get('/reports/export/excel/{customer}/order/{onlyapprove}/{department}/between/{date_start}/and/{date_end}', [Reports_Controller::class, 'ExportExcelOrder']);
    Route::get('/reports/export/excel/{customer}/process/{onlyapprove}/{department}/between/{date_start}/and/{date_end}', [Reports_Controller::class, 'ExportExcelProcess']);

    // UsersPermission_Controller
    Route::get('/settings/permitt', [UsersPermission_Controller::class, 'UserPermit']);

    // Notifications
    Route::get('/notifications', [Notifications_Controller::class, 'getNotifications']);
    Route::get('/notificationsdetails', [Notifications_Controller::class, 'getNotificationEditOrderDetail']);
    Route::post('/notificationreaded', [Notifications_Controller::class, 'NotificationReaded']);

});

Route::get('/logout', function () {
    Cookie::queue(Cookie::forget('Username_server'));
    Cookie::queue(Cookie::forget('Username_server_Permission'));
    return redirect()->route('login');
})->name('logout');

// Route::get('/process', function () {
//     return view('process');
// });