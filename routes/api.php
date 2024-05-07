<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CommonApiController;
use App\Http\Controllers\Api\ParcelController;
use App\Http\Controllers\Api\InspectionController;
use App\Http\Controllers\Api\InductionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [LoginController::class, 'login']);
Route::post('signUp', [LoginController::class, 'signUp']);

Route::post('forgotPassword', [LoginController::class, 'forgotPassword']);

Route::post('verifyOtp', [LoginController::class, 'verifyOtp']);

Route::post('changePassword', [LoginController::class, 'changePassword']);

Route::post('relaodtoken', [ClientController::class, 'relaodtoken']);


Route::group( ['middleware' => ['auth:driver'] ],function(){

    // Shift Section

    Route::post('addShift', [ShiftController::class, 'addShift']);

    Route::post('missedShift', [ShiftController::class, 'missedShift']);

    Route::get('viewAllMissShift', [ShiftController::class, 'viewAllMissShift']);

    Route::post('addLocation', [ShiftController::class, 'addLocation']);

    Route::post('trackLocation', [ShiftController::class, 'trackLocation']);

    Route::post('shiftStart', [ShiftController::class, 'shiftStart']);

    Route::post('deleteShift', [ShiftController::class, 'deleteShift']);

    Route::post('shiftDetail', [ShiftController::class, 'shiftDetail']);

    Route::post('allShift', [ShiftController::class, 'showShift']); // Home page listing 10 latest

    Route::post('homePageShift', [ShiftController::class, 'homePageShift']); // Home page listing 10 latest

    Route::post('allDropDown', [ShiftController::class, 'allDropDown']);

    Route::post('updateProfile', [LoginController::class, 'updateProfile']);

    Route::post('uploadDocument', [LoginController::class, 'uploadDocument']);

    Route::get('getDriverDocs', [LoginController::class, 'getDriverDocs']);

    Route::post('myShiftDetail', [ShiftController::class, 'myShiftDetail']);

    Route::post('filterMyShift', [ShiftController::class, 'filterMyShift']);

    Route::get('shiftStatus', [ShiftController::class, 'shiftStatus']);

    Route::post('ok', [ShiftController::class, 'ok']);

    Route::get('states', [ShiftController::class, 'allStates']);

    Route::post('addParcel', [ParcelController::class, 'addParcel']);

    Route::post('deleteParcel', [ParcelController::class, 'deleteParcel']);

    Route::post('deliverParcel', [ParcelController::class, 'deliverParcel']);

    Route::post('updateParcel', [ParcelController::class, 'updateParcel']);

    Route::post('updateParcel', [ParcelController::class, 'updateParcel']);

    Route::post('updateShiftTiming', [ShiftController::class, 'updateShiftTiming']);

    Route::post('allParcel', [ParcelController::class, 'allParcel']);

    Route::post('parcelDelivered', [ParcelController::class, 'parcelDelivered']);

    Route::post('searchLocation', [ParcelController::class, 'searchLocation']);

    Route::post('routeOptimization', [ParcelController::class, 'routeOptimization']);

    Route::post('finishShift', [ParcelController::class, 'finishShift']);

    Route::get('inspectionRego', [InspectionController::class, 'inspectionRego']);

    Route::post('addInspection', [InspectionController::class, 'addInspection']);

    Route::get('allInduction', [InductionController::class, 'allInspection']);

    Route::post('inductionDetail', [InductionController::class, 'inspectionDetail']);

    Route::get('inspectionList', [InductionController::class, 'inspectionDetail2']);

    Route::post('uploadInduction', [InductionController::class, 'uploadInspection']);

    Route::post('allClient', [ClientController::class, 'allClient']);

    Route::post('getCostCenter', [ClientController::class, 'getCostCenter']);

    Route::post('getProfile', [ClientController::class, 'getProfile']);



    Route::get('common-api', [CommonApiController::class, 'CommonApi']);
    Route::post('complete-shift', [CommonApiController::class, 'completeShift']);




    Route::post('googleOptimizeRoot', function (Request $requrst) {

        $data = $requrst->input('destinations');

        // die($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://routes.googleapis.com/distanceMatrix/v2:computeRouteMatrix',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data,
          CURLOPT_HTTPHEADER => array(
            'X-Goog-FieldMask: originIndex,destinationIndex,duration,distanceMeters,status,condition',
            'X-Goog-Api-Key: AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s',
            'Content-Type: text/plain'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    });


    Route::post('OptimizeRootUsingrouteMatrix', function (Request $request) {

        $data = $request->input('data');
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://routes.googleapis.com/directions/v2:computeRoutes',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data,
          CURLOPT_HTTPHEADER => array(
            'X-Goog-Api-Key: AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s',
            'X-Goog-FieldMask: routes.duration,routes.distanceMeters,routes.polyline,routes.optimizedIntermediateWaypointIndex',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    });

});


// Client
