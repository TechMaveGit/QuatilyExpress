<?php

use App\Http\Controllers\Admin\Administration;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\Expenses;
use App\Http\Controllers\Admin\Homecontroller;
use App\Http\Controllers\Admin\InductionController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\LiveTrackingController;
use App\Http\Controllers\Admin\Personcontroller;
use App\Http\Controllers\Admin\ShiftManagement;
use App\Http\Controllers\Admin\VehicleController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('login', [AdminLoginController::class, 'index'])->name('admin');
Route::get('/', function () {
    $data['pageTitle'] = 'Dashboard';

    return view('admin.login', $data);
})->name('home_page');
Route::get('/testing', [AdminLoginController::class, 'testing'])->name('testing');
Route::get('/admin', [AdminLoginController::class, 'index'])->name('admin');
Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::get('cache', function () {
    Artisan::call('optimize');
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
});
Route::prefix('admin')->middleware('auth:adminLogin')->namespace('admin')->group(function () {
    Route::group(['prefix' => 'ajaxTable'], function () {
        Route::match(['get', 'post'], '/ajaxClient', [ClientController::class, 'clientsAjax'])->name('clients.ajaxTable');
    });
    Route::match(['get', 'post'], '/ajaxPerson', [VehicleController::class, 'VehicleAjax'])->name('vehicle.ajaxTable');
    Route::match(['get', 'post'], '/getAjaxData', [VehicleController::class, 'getAjaxData'])->name('getAjaxData');
    Route::match(['get', 'post'], '/dashboard', [Homecontroller::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::match(['get', 'post'], '/profile', [AdminLoginController::class, 'profile'])->name('admin.profile');
    Route::match(['get', 'post'], '/updatePassword', [AdminLoginController::class, 'updatePassword'])->name('admin.updatePassword');

    Route::match(['get', 'post'], '/ajax-table-person', [Personcontroller::class, 'personAjaxTable'])->name('person.ajax.table');
    
    Route::group(['prefix' => 'administration'], function () {
        Route::match(['get', 'post'], '/role', [Administration::class, 'index'])->name('administration.role');
        Route::match(['get', 'post'], '/role-add', [Administration::class, 'roleAdd'])->name('administration.role.add');
        Route::match(['get', 'post'], '/role-edit/{id}', [Administration::class, 'roleEdit'])->name('administration.role.edit');
        Route::match(['get', 'post'], '/delete-role', [Administration::class, 'deleterole'])->name('deleterole');
        Route::match(['get', 'post'], 'view-role-permission/{id}', [Administration::class, 'viewRolePermission'])->name('view.role.permission');
        Route::match(['get', 'post'], 'edit-role-permission/{id}', [Administration::class, 'editRolePermission'])->name('edit.role.permission');
        Route::match(['get', 'post'], 'view-role', [Administration::class, 'viewRole'])->name('admin.viewRole');
        // user Access
        Route::match(['get', 'post'], '/user-access', [Administration::class, 'userAccess'])->name('administration.userAccess');
        Route::match(['get', 'post'], '/user-access-assign', [Administration::class, 'userAccessAssign'])->name('administration.userAccessAssign');
        Route::match(['get', 'post'], '/delete-access-role', [Administration::class, 'deleteAccessRole'])->name('delete.access.role');
        Route::match(['get', 'post'], '/user-access-assign-edit/{id}', [Administration::class, 'assignEdit'])->name('administration.assignEdit');
        Route::match(['get', 'post'], '/system-configuration', [Administration::class, 'systemConfiguration'])->name('administration.system-configuration');
        Route::match(['get', 'post'], '/getUserDetail', [Administration::class, 'getUserDetail'])->name('admin.getUserDetail');
    });
    Route::group(['prefix' => 'expenses'], function () {
        Route::match(['get', 'post'], '/expense-dashboard', [Expenses::class, 'expense'])->name('expense-dashboard');
        Route::match(['get', 'post'], '/expense', [Expenses::class, 'getRego'])->name('get.rego');
        Route::match(['get', 'post'], '/expense-sheet', [Expenses::class, 'expenseSheet'])->name('expense.sheet');
        Route::match(['get', 'post'], '/add-vehicale', [Expenses::class, 'addVehicle'])->name('add.vehicle');
        Route::match(['get', 'post'], '/add-op-vehicale', [Expenses::class, 'addopVehicle'])->name('add.op.vehicle');
        Route::match(['get', 'post'], '/delete-general-exp', [Expenses::class, 'deletGeneralExp'])->name('delet.General.Exp');
        Route::match(['get', 'post'], '/delete-total-expenses', [Expenses::class, 'deletTotalExp'])->name('delet.Delet.Total.Exp');
        Route::match(['get', 'post'], '/delete-operaction', [Expenses::class, 'deletTotalOperaction'])->name('delet.Delet.opeaaction');
    });
    Route::group(['prefix' => 'shift-management'], function () {
        Route::match(['get', 'post'], '/shift', [ShiftManagement::class, 'shift'])->name('admin.shift');
        Route::match(['get', 'post'], '/shiftStart', [Homecontroller::class, 'shiftStart'])->name('admin.shift.start');
        Route::match(['get', 'post'], '/finishShift', [Homecontroller::class, 'finishShift'])->name('admin.finish.Shift');
        Route::match(['get', 'post'], '/shift-add', [ShiftManagement::class, 'shiftAdd'])->name('admin.shift.add');
        Route::post('/calculate-end-date', [ShiftManagement::class, 'calculateEndDate'])->name('admin.shift.calculate');
        Route::match(['get', 'post'], '/add-missed-shift', [ShiftManagement::class, 'shiftMissedAdd'])->name('admin.shift.missed.shift');
        Route::match(['get', 'post'], '/myshift', [ShiftManagement::class, 'myshift'])->name('admin.shift.myshift');
        Route::match(['get', 'post'], '/myAjaxshift', [ShiftManagement::class, 'myAjaxshift'])->name('admin.myAjaxshift');
        Route::match(['get', 'post'], '/shift-report', [ShiftManagement::class, 'shiftreport'])->name('admin.shift.report');
        Route::match(['get', 'post'], '/import-shift', [ShiftManagement::class, 'importShift'])->name('admin.shift.import');
        Route::match(['get', 'post'], '/import-client', [ShiftManagement::class, 'importClient'])->name('admin.client.import');
        Route::match(['get', 'post'], '/import-clientRate', [ShiftManagement::class, 'importClientRate'])->name('admin.client.rate.import');
        Route::match(['get', 'post'], '/import-ClientBase', [ShiftManagement::class, 'importClientBase'])->name('admin.client.base.import');
        Route::match(['get', 'post'], '/shift-report-view/{id}', [ShiftManagement::class, 'shiftReportView'])->name('admin.shift.report.view');
        Route::match(['get', 'post'], '/shift-report-edit/{id}', [ShiftManagement::class, 'shiftReportEdit'])->name('admin.shift.report.edit');
        Route::match(['get', 'post'], '/shift-appproved', [ShiftManagement::class, 'shiftapr'])->name('admin.shift.shiftapprove');
        Route::match(['get', 'post'], '/shift-rejected', [ShiftManagement::class, 'shiftRejected'])->name('admin.shift.shiftRejected');
        Route::match(['get', 'post'], '/shift-paid', [ShiftManagement::class, 'shiftPaid'])->name('admin.shift.shiftPaid');
        Route::match(['get', 'post'], '/route-map/{id}', [ShiftManagement::class, 'routeMap'])->name('admin.shift.route.map');
        Route::match(['get', 'post'], '/shift-parcels/{id}', [ShiftManagement::class, 'shiftparcels'])->name('admin.shift.parcels');
        Route::match(['get', 'post'], '/parcels-deliver', [ShiftManagement::class, 'shiftapprove'])->name('admin.package.Deliver');
        Route::match(['get', 'post'], '/get-client', [ShiftManagement::class, 'getClient'])->name('admin.getClient');
        Route::match(['get', 'post'], '/getCostCenter', [ShiftManagement::class, 'getCostCenter'])->name('admin.getCostCenter');
        Route::match(['get', 'post'], '/getClientBase', [ShiftManagement::class, 'getClientBase'])->name('admin.getClientBase');
        Route::match(['get', 'post'], '/getDriverResponiable', [ShiftManagement::class, 'getDriverResponiable'])->name('admin.getDriver.Responiable');
        Route::match(['get', 'post'], '/geClient', [ShiftManagement::class, 'getClientA'])->name('admin.gct');
        Route::match(['get', 'post'], '/getCst', [ShiftManagement::class, 'getCostCenterB'])->name('admin.gCc');
        Route::match(['get', 'post'], '/export-shifts', [ShiftManagement::class, 'exportShiftReport'])->name('export.shifts');
    });
    Route::group(['prefix' => 'person'], function () {
        Route::match(['get', 'post'], '/', [Personcontroller::class, 'person'])->name('person');
        Route::match(['get', 'post'], '/add', [Personcontroller::class, 'personAdd'])->name('person.add');
        Route::match(['get', 'post'], '/Persondocument/delete', [Personcontroller::class, 'Persondocument'])->name('person.Persondocument.delete');
        Route::match(['get', 'post'], '/view/{id}', [Personcontroller::class, 'personview'])->name('person.view');
        Route::match(['get', 'post'], '/deletePerson', [Personcontroller::class, 'deletePerson'])->name('person.deletePerson');
        Route::match(['get', 'post'], '/edit/{id}', [Personcontroller::class, 'personedit'])->name('person.edit');
        // delete person address
        Route::match(['get', 'post'], '/delete', [Personcontroller::class, 'deleteaddress'])->name('person.delete.address');
        Route::match(['get', 'post'], '/edit-person-edit', [Personcontroller::class, 'editPersonId'])->name('editPersonId');
        // add reminder
        Route::match(['get', 'post'], '/add/reminder', [Personcontroller::class, 'reminderAdd'])->name('reminder.add');
        Route::match(['get', 'post'], '/delete/reminder', [Personcontroller::class, 'reminderPerson'])->name('person.delete.reminder');
        Route::match(['get', 'post'], '/delete/rates', [Personcontroller::class, 'deleteRate'])->name('deleteRate');
        // Route::match(['get','post'],'/edit/{id}', [Personcontroller::class, 'reminderedit'])->name('reminder.edit');
        Route::match(['get', 'post'], '/person/status', [Personcontroller::class, 'personStatus'])->name('personStatus');

       
    });
    Route::group(['prefix' => 'clients'], function () {
        Route::match(['get', 'post'], '/', [ClientController::class, 'clients'])->name('clients');
        Route::match(['get', 'post'], '/add-client', [ClientController::class, 'clientAddfirst'])->name('client.add');
        Route::match(['get', 'post'], '/clientValidateState', [ClientController::class, 'clientValidateState'])->name('admin.client.validate.state');
        Route::match(['get', 'post'], '/addClient', [ClientController::class, 'addClient'])->name('add.client');
        Route::match(['get', 'post'], '/view/{id}', [ClientController::class, 'clientView'])->name('client.view');
        Route::match(['get', 'post'], '/edit/{id}', [ClientController::class, 'clientEdit'])->name('client.edit');
        Route::match(['get', 'post'], '/clientRateEdit', [ClientController::class, 'clientRateEdit'])->name('client.clientRateEdit');
        Route::match(['get', 'post'], '/delete', [ClientController::class, 'clientdelete'])->name('client.delete');
        Route::match(['get', 'post'], '/delete-client', [ClientController::class, 'deleteClient'])->name('delete-client');
        Route::match(['get', 'post'], '/clientlistDelete/{id}', [ClientController::class, 'clientlistDelete'])->name('clientDelete');
        Route::match(['get', 'post'], '/rate', [ClientController::class, 'clientrate'])->name('client.rate');
        Route::match(['get', 'post'], '/client/centers', [ClientController::class, 'clientcenters'])->name('client.centers');
        Route::match(['get', 'post'], '/client/base', [ClientController::class, 'clientbase'])->name('client.base.delete');
        Route::match(['get', 'post'], '/delete/address', [ClientController::class, 'deleteaddress'])->name('client.delete.address');
        Route::match(['get', 'post'], '/client/status', [ClientController::class, 'clientStatus'])->name('client.status');
        Route::match(['get', 'post'], '/export-clients', [ClientController::class, 'exportClients'])->name('export.clients');
    });
    Route::group(['prefix' => 'vehicle'], function () {
        Route::match(['get', 'post'], '/', [VehicleController::class, 'vehicle'])->name('vehicle');
        Route::match(['get', 'post'], '/add', [VehicleController::class, 'vehicleAdd'])->name('vehicle.add');
        Route::match(['get', 'post'], '/view/{id}', [VehicleController::class, 'vehicleView'])->name('vehicle.view');
        Route::match(['get', 'post'], '/edit/{id}', [VehicleController::class, 'vehicleEdit'])->name('vehicle.edit');
        Route::match(['get', 'post'], '/delete', [VehicleController::class, 'vehicledelete'])->name('vehicle.delete');
        Route::match(['get', 'post'], '/vehicle/status', [VehicleController::class, 'vehicleStatus'])->name('vehicle.status');
        Route::match(['get', 'post'], '/type', [VehicleController::class, 'vehicleType'])->name('vehicle.vehicleType');
        Route::match(['get', 'post'], '/type/edit', [VehicleController::class, 'vehicleTypeEdit'])->name('vehicle.vehicleTypeEdit');
        Route::match(['get', 'post'], '/type/delete', [VehicleController::class, 'vehicleTypeDelete'])->name('vehicle.vehicleTypeDelete');
    });
    Route::group(['prefix' => 'state'], function () {
        Route::match(['get', 'post'], '/', [LiveTrackingController::class, 'state'])->name('state');
        Route::match(['get', 'post'], '/edit-state', [LiveTrackingController::class, 'stateEdit'])->name('state.edit');
        Route::match(['get', 'post'], '/delete-state', [LiveTrackingController::class, 'stateDelete'])->name('state.delete');
    });
    Route::group(['prefix' => 'live-tracking'], function () {
        Route::match(['get', 'post'], '/', [LiveTrackingController::class, 'liveTracking'])->name('live-tracking');
        Route::match(['get', 'post'], '/getShift', [LiveTrackingController::class, 'getShift'])->name('get.shift');
        Route::match(['get', 'post'], '/current-driver-location', [LiveTrackingController::class, 'getDriverLocation'])->name('driver.location');
    });
    Route::group(['prefix' => 'inspection'], function () {
        Route::match(['get', 'post'], '/', [InspectionController ::class, 'inspection'])->name('inspection');
        Route::match(['get', 'post'], '/add', [InspectionController::class, 'inspectionAdd'])->name('inspection.add');
        Route::match(['get', 'post'], '/edit/{id}', [InspectionController::class, 'inspectionedit'])->name('inspection.edit');
        Route::match(['get', 'post'], '/view/{id}', [InspectionController::class, 'inspectionView'])->name('inspection.view');
    });
    Route::group(['prefix' => 'induction'], function () {
        Route::match(['get', 'post'], '/', [InductionController ::class, 'induction'])->name('induction');
        Route::match(['get', 'post'], '/add', [InductionController::class, 'inductionAdd'])->name('induction.add');
        Route::match(['get', 'post'], '/delete', [InductionController::class, 'inductiondelete'])->name('induction.delete');
        Route::match(['get', 'post'], '/edit/{id}', [InductionController::class, 'inductionEdit'])->name('induction.edit');
        Route::match(['get', 'post'], '/view/{id}', [InductionController::class, 'inductionView'])->name('induction.view');
        Route::match(['get', 'post'], '/driver-signature/{id}', [InductionController::class, 'inductionDriver'])->name('induction.driver');
        Route::match(['get', 'post'], '/uplaod-signature/{id}', [InductionController::class, 'uploadSignature'])->name('induction.uploadSignature');
        Route::match(['get', 'post'], '/driver-upload-signature/{id}', [InductionController::class, 'driveruploadSignature'])->name('induction.upload.signature');
    });
    Route::group(['prefix' => 'driver'], function () {
        Route::match(['get', 'post'], '/', [DriverController ::class, 'driver'])->name('driver');
        Route::match(['get', 'post'], '/add', [DriverController::class, 'driverAdd'])->name('driver.add');
        Route::match(['get', 'post'], '/view', [DriverController::class, 'driverView'])->name('driver.view');
        Route::match(['get', 'post'], '/driver-document/{id}', [DriverController::class, 'driverInduction'])->name('driver.induction');
    });
});

Route::match(['get', 'post'], '/test-track', [LiveTrackingController ::class, 'liveTrack'])->name('liveTrack');
Route::view('/test-tt', 'admin.test');
// Route::view('URI', 'viewName');('/test-tt', [LiveTrackingController ::class, 'liveTrack'])->name('liveTrack');
