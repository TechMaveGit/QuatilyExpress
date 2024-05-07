<?php



use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Admin\Expenses;

use App\Http\Controllers\Admin\Administration;

use App\Http\Controllers\Admin\Homecontroller;

use App\Http\Controllers\Admin\ShiftManagement;

use App\Http\Controllers\Admin\ClientController;

use App\Http\Controllers\Admin\DriverController;

use App\Http\Controllers\Admin\Personcontroller;

use App\Http\Controllers\Admin\VehicleController;

use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\InductionController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\InspectionController;
use App\Http\Controllers\Admin\LiveTrackingController;

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

    $data['pageTitle']="Dashboard";
    return view('admin.login',$data);

});


Auth::routes();

Route::get('/testing', [AdminLoginController::class, 'testing'])->name('testing');

Route::get('/admin', [AdminLoginController::class, 'index'])->name('admin');

Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');

Route::get('cache',function()

{

    Artisan::call('optimize');

    Artisan::call('cache:clear');

    Artisan::call('route:cache');

    Artisan::call('route:clear');

    Artisan::call('view:clear');

    Artisan::call('config:clear');

});

Route::prefix('admin')->middleware('auth:adminLogin')->namespace('admin')->group(function () {


    Route::group(['prefix' => 'ajaxTable'], function()
        {
            Route::any('/ajaxClient', [ClientController::class, 'clientsAjax'])->name('clients.ajaxTable');
        });



    Route::any('/ajaxPerson', [VehicleController::class, 'VehicleAjax'])->name('vehicle.ajaxTable');
    Route::any('/getAjaxData', [VehicleController::class, 'getAjaxData'])->name('getAjaxData');





    Route::any('/dashboard', [Homecontroller::class, 'index'])->name('admin.dashboard');

    Route::get('/logout',    [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::any('/profile',    [AdminLoginController::class, 'profile'])->name('admin.profile');

    Route::any('/updatePassword',    [AdminLoginController::class, 'updatePassword'])->name('admin.updatePassword');

    Route::any('new-role', [DashboardController::class, 'newRole'])->name('add.role');

    Route::group(['prefix' => 'administration'], function()

    {

        Route::any('/role', [Administration::class, 'index'])->name('administration.role');

        Route::any('/role-add', [Administration::class, 'roleAdd'])->name('administration.role.add');

        Route::any('/role-edit/{id}', [Administration::class, 'roleEdit'])->name('administration.role.edit');

        Route::any('/delete-role', [Administration::class, 'deleterole'])->name('deleterole');

        Route::any('view-role-permission/{id}', [Administration::class, 'viewRolePermission'])->name('view.role.permission');

        Route::any('edit-role-permission/{id}', [Administration::class, 'editRolePermission'])->name('edit.role.permission');


        Route::any('view-role', [Administration::class, 'viewRole'])->name('admin.viewRole');

        // user Access

        Route::any('/user-access', [Administration::class, 'userAccess'])->name('administration.userAccess');

        Route::any('/user-access-assign', [Administration::class, 'userAccessAssign'])->name('administration.userAccessAssign');

        Route::any('/delete-access-role', [Administration::class, 'deleteAccessRole'])->name('delete.access.role');

        Route::any('/user-access-assign-edit/{id}', [Administration::class, 'assignEdit'])->name('administration.assignEdit');

        Route::any('/system-configuration', [Administration::class, 'systemConfiguration'])->name('administration.system-configuration');

        Route::any('/getUserDetail', [Administration::class, 'getUserDetail'])->name('admin.getUserDetail');

    });

    Route::group(['prefix' => 'expenses'], function()

    {

        Route::any('/expense-dashboard', [Expenses::class, 'expense'])->name('expense-dashboard');

        Route::any('/expense', [Expenses::class, 'getRego'])->name('get.rego');

        Route::any('/expense-sheet', [Expenses::class, 'expenseSheet'])->name('expense.sheet');

        Route::any('/add-vehicale', [Expenses::class, 'addVehicle'])->name('add.vehicle');

        Route::any('/add-op-vehicale', [Expenses::class, 'addopVehicle'])->name('add.op.vehicle');

        Route::any('/delete-general-exp', [Expenses::class, 'deletGeneralExp'])->name('delet.General.Exp');

        Route::any('/delete-total-expenses', [Expenses::class, 'deletTotalExp'])->name('delet.Delet.Total.Exp');

        Route::any('/delete-operaction', [Expenses::class, 'deletTotalOperaction'])->name('delet.Delet.opeaaction');

    });

    Route::group(['prefix' => 'shift-management'], function()

    {

        Route::any('/shift', [ShiftManagement::class, 'shift'])->name('admin.shift');

        Route::any('/shiftStart', [Homecontroller::class, 'shiftStart'])->name('admin.shift.start');

        Route::any('/finishShift', [Homecontroller::class, 'finishShift'])->name('admin.finish.Shift');

        Route::any('/shift-add', [ShiftManagement::class, 'shiftAdd'])->name('admin.shift.add');

        Route::post('/calculate-end-date', [ShiftManagement::class, 'calculateEndDate'])->name('admin.shift.calculate');




        Route::any('/add-missed-shift', [ShiftManagement::class, 'shiftMissedAdd'])->name('admin.shift.missed.shift');





        Route::any('/myshift', [ShiftManagement::class, 'myshift'])->name('admin.shift.myshift');


        Route::any('/myAjaxshift', [ShiftManagement::class, 'myAjaxshift'])->name('admin.myAjaxshift');

        Route::any('/shift-report', [ShiftManagement::class, 'shiftreport'])->name('admin.shift.report');


        Route::any('/import-shift', [ShiftManagement::class, 'importShift'])->name('admin.shift.import');

        Route::any('/import-client', [ShiftManagement::class, 'importClient'])->name('admin.client.import');
        Route::any('/import-clientRate', [ShiftManagement::class, 'importClientRate'])->name('admin.client.rate.import');
        Route::any('/import-ClientBase', [ShiftManagement::class, 'importClientBase'])->name('admin.client.base.import');


        Route::any('/shift-report-view/{id}', [ShiftManagement::class, 'shiftReportView'])->name('admin.shift.report.view');


        Route::any('/shift-report-edit/{id}', [ShiftManagement::class, 'shiftReportEdit'])->name('admin.shift.report.edit');



        Route::any('/shift-appproved', [ShiftManagement::class, 'shiftapr'])->name('admin.shift.shiftapprove');

        Route::any('/shift-rejected', [ShiftManagement::class, 'shiftRejected'])->name('admin.shift.shiftRejected');

        Route::any('/shift-paid', [ShiftManagement::class, 'shiftPaid'])->name('admin.shift.shiftPaid');

        Route::any('/route-map/{id}', [ShiftManagement::class, 'routeMap'])->name('admin.shift.route.map');

        Route::any('/shift-parcels/{id}', [ShiftManagement::class, 'shiftparcels'])->name('admin.shift.parcels');

        Route::any('/parcels-deliver', [ShiftManagement::class, 'shiftapprove'])->name('admin.package.Deliver');

        Route::any('/get-client', [ShiftManagement::class, 'getClient'])->name('admin.getClient');

        Route::any('/getCostCenter', [ShiftManagement::class, 'getCostCenter'])->name('admin.getCostCenter');

        Route::any('/getClientBase', [ShiftManagement::class, 'getClientBase'])->name('admin.getClientBase');

        Route::any('/getDriverResponiable', [ShiftManagement::class, 'getDriverResponiable'])->name('admin.getDriver.Responiable');

        Route::any('/geClient', [ShiftManagement::class, 'getClientA'])->name('admin.gct');

        Route::any('/getCst', [ShiftManagement::class, 'getCostCenterB'])->name('admin.gCc');

        Route::any('/export-shifts', [ShiftManagement::class, 'exportShiftReport'])->name('export.shifts');


    });



    Route::group(['prefix' => 'person'], function()

    {

        Route::any('/', [Personcontroller::class, 'person'])->name('person');

        Route::any('/add', [Personcontroller::class, 'personAdd'])->name('person.add');

        Route::any('/Persondocument/delete', [Personcontroller::class, 'Persondocument'])->name('person.Persondocument.delete');

        Route::any('/view/{id}', [Personcontroller::class, 'personview'])->name('person.view');

        Route::any('/deletePerson', [Personcontroller::class, 'deletePerson'])->name('person.deletePerson');

        Route::any('/edit/{id}', [Personcontroller::class, 'personedit'])->name('person.edit');



        // delete person address

        Route::any('/delete', [Personcontroller::class, 'deleteaddress'])->name('person.delete.address');

        Route::any('/edit-person-edit', [Personcontroller::class, 'editPersonId'])->name('editPersonId');

        // add reminder

        Route::any('/add/reminder', [Personcontroller::class, 'reminderAdd'])->name('reminder.add');

        Route::any('/delete/reminder', [Personcontroller::class, 'reminderPerson'])->name('person.delete.reminder');

        Route::any('/delete/rates', [Personcontroller::class, 'deleteRate'])->name('deleteRate');

        // Route::any('/edit/{id}', [Personcontroller::class, 'reminderedit'])->name('reminder.edit');

        Route::any('/person/status', [Personcontroller::class, 'personStatus'])->name('personStatus');

    });



    Route::group(['prefix' => 'clients'], function()
    {
        Route::any('/', [ClientController::class, 'clients'])->name('clients');

        Route::any('/add-client', [ClientController::class, 'clientAddfirst'])->name('client.add');

        Route::any('/clientValidateState', [ClientController::class, 'clientValidateState'])->name('admin.client.validate.state');

        Route::any('/addClient', [ClientController::class, 'addClient'])->name('add.client');

        Route::any('/view/{id}', [ClientController::class, 'clientView'])->name('client.view');

        Route::any('/edit/{id}', [ClientController::class, 'clientEdit'])->name('client.edit');

        Route::any('/clientRateEdit', [ClientController::class, 'clientRateEdit'])->name('client.clientRateEdit');

        Route::any('/delete', [ClientController::class, 'clientdelete'])->name('client.delete');

        Route::any('/delete-client', [ClientController::class, 'deleteClient'])->name('delete-client');

        Route::any('/clientlistDelete/{id}', [ClientController::class, 'clientlistDelete'])->name('clientDelete');

        Route::any('/rate', [ClientController::class, 'clientrate'])->name('client.rate');

        Route::any('/client/centers', [ClientController::class, 'clientcenters'])->name('client.centers');

        Route::any('/client/base', [ClientController::class, 'clientbase'])->name('client.base.delete');

        Route::any('/delete/address', [ClientController::class, 'deleteaddress'])->name('client.delete.address');

        Route::any('/client/status', [ClientController::class, 'clientStatus'])->name('client.status');

        Route::any('/export-clients', [ClientController::class, 'exportClients'])->name('export.clients');

    });


    Route::group(['prefix' => 'vehicle'], function()
    {

        Route::any('/', [VehicleController::class, 'vehicle'])->name('vehicle');

        Route::any('/add', [VehicleController::class, 'vehicleAdd'])->name('vehicle.add');

        Route::any('/view/{id}', [VehicleController::class, 'vehicleView'])->name('vehicle.view');

        Route::any('/edit/{id}', [VehicleController::class, 'vehicleEdit'])->name('vehicle.edit');

        Route::any('/delete', [VehicleController::class, 'vehicledelete'])->name('vehicle.delete');

        Route::any('/vehicle/status', [VehicleController::class, 'vehicleStatus'])->name('vehicle.status');

      Route::any('/type', [VehicleController::class, 'vehicleType'])->name('vehicle.vehicleType');

       Route::any('/type/edit', [VehicleController::class, 'vehicleTypeEdit'])->name('vehicle.vehicleTypeEdit');
       Route::any('/type/delete', [VehicleController::class, 'vehicleTypeDelete'])->name('vehicle.vehicleTypeDelete');

    });


    Route::group(['prefix' => 'state'], function()
    {
        Route::any('/', [LiveTrackingController::class, 'state'])->name('state');
        Route::any('/edit-state', [LiveTrackingController::class, 'stateEdit'])->name('state.edit');
        Route::any('/delete-state', [LiveTrackingController::class, 'stateDelete'])->name('state.delete');
    });



    Route::group(['prefix' => 'live-tracking'], function()
    {
        Route::any('/', [LiveTrackingController::class, 'liveTracking'])->name('live-tracking');
        Route::any('/getShift', [LiveTrackingController::class, 'getShift'])->name('get.shift');
        Route::any('/current-driver-location', [LiveTrackingController::class, 'getDriverLocation'])->name('driver.location');



    });



    Route::group(['prefix' => 'inspection'], function()
    {
        Route::any('/', [InspectionController ::class, 'inspection'])->name('inspection');
        Route::any('/add', [InspectionController::class, 'inspectionAdd'])->name('inspection.add');
        Route::any('/edit/{id}', [InspectionController::class, 'inspectionedit'])->name('inspection.edit');
        Route::any('/view/{id}', [InspectionController::class, 'inspectionView'])->name('inspection.view');
    });



    Route::group(['prefix' => 'induction'], function()
    {
        Route::any('/', [InductionController ::class, 'induction'])->name('induction');

        Route::any('/add', [InductionController::class, 'inductionAdd'])->name('induction.add');

        Route::any('/delete', [InductionController::class, 'inductiondelete'])->name('induction.delete');

        Route::any('/edit/{id}', [InductionController::class, 'inductionEdit'])->name('induction.edit');

        Route::any('/view/{id}', [InductionController::class, 'inductionView'])->name('induction.view');

        Route::any('/driver-signature/{id}', [InductionController::class, 'inductionDriver'])->name('induction.driver');

        Route::any('/uplaod-signature/{id}', [InductionController::class, 'uploadSignature'])->name('induction.uploadSignature');

        Route::any('/driver-upload-signature/{id}', [InductionController::class, 'driveruploadSignature'])->name('induction.upload.signature');
    });



    Route::group(['prefix' => 'driver'], function()

    {

        Route::any('/', [DriverController ::class, 'driver'])->name('driver');

        Route::any('/add', [DriverController::class, 'driverAdd'])->name('driver.add');

        Route::any('/view', [DriverController::class, 'driverView'])->name('driver.view');

        Route::any('/driver-document/{id}', [DriverController::class, 'driverInduction'])->name('driver.induction');

    });



});

