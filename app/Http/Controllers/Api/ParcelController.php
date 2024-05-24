<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Client;
use App\Models\Finishshift;
use App\Models\Parcels;
use App\Models\Shift;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class ParcelController extends Controller
{
    protected $notfound = 404;
    protected $successStatus = 200;
    protected $unauthorisedStatus = 400;
    protected $internalServererror = 500;
    protected $driverId;

    public function __construct(Request $request)
    {
        $this->driverId = auth('driver')->user()->id ?? '';
    }

    public function addParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shiftId'      => 'required|integer',
            'receiverName'  => 'nullable',
            'scanParcel'    => 'required',
            'location'      => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            // "parcelIamge"   => "required",
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $Parcel = new Parcels();
        $Parcel->driverId = $this->driverId;
        $Parcel->shiftId = $request->shiftId;
        $Parcel->receiverName = $request->receiverName??null;
        $Parcel->scanParcel = $request->scanParcel;
        $Parcel->location = $request->location;
        $Parcel->latitude = $request->latitude;
        $Parcel->longitude = $request->longitude;
        $Parcel->save();

        $parcelIamge = $request->file('parcelIamge');
        $packageImage = json_decode(json_encode($parcelIamge));
        if ($packageImage) {
            $hgcount = count($packageImage);
        } else {
            $hgcount = 0;
        }
        for ($i = 0; $i < $hgcount; $i++) {
            $items = '';
            if ($request->hasFile('parcelIamge')) {
                $image = $request->file('parcelIamge')[$i];
                $dateFolder = 'driver/parcel';
                $items = ImageController::upload($image, $dateFolder);
            }
            $packageItem = [
                'parcelId'    => $Parcel->id,
                'parcelImage' => $items,
            ];
            DB::table('addparcelimages')->insert($packageItem);
        }

        if ($Parcel) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Parcel Added Successfully',
            ]);
        }
    }

    public function deleteParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parcelId'      => 'required|integer',
            'shiftId'      => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $parcelId = $request->input('parcelId');
        $shiftId = $request->input('shiftId');

        $checkParcel = Parcels::where(['id' => $parcelId, 'shiftId' => $shiftId])->first();
        if ($checkParcel) {
            $parcel = Parcels::whereId($parcelId)->delete();
            if ($parcel) {
                return response()->json([
                    'status' => $this->successStatus,
                    'message' => 'Parcel Deleted Successfully',
                ]);
            }
        } else {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Parcel id not found',
            ]);
        }

        if ($parcel) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Parcel Deleted Successfully',
            ]);
        }
    }

    public function parcelDetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'parcel_id'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $parcelId = $request->input('parcel_id');
        $Parcels = Parcels::where(['id' => $parcelId, 'driverId' => $this->driverId])->first();
        if ($Parcels) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
                'parcelImage' => env('PAREL_IMAGE'),
                'data' => $Parcels,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function deliverParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // "parcelIamge"     => "required",
            'deliveredTo' => 'required',
            'deliver_lat' => 'required',
            'deliver_lng' => 'required',
            'deliver_address' => 'required',
            'parcelId' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $parcelId = $request->input('parcelId');
        $deliveredTo = $request->input('deliveredTo');
        $delivered_latitude = $request->input('deliver_lat');
        $delivered_longitude = $request->input('deliver_lng');
        if ($request->file('parcelIamge') != '') {
            $image = $request->file('parcelIamge');
            $dateFolder = 'driver/parcel';
            $photo = ImageController::upload($image, $dateFolder);
        } else {
            $photo = '';
        }

        $checkParcel = Parcels::whereId($parcelId)->where('status', '2')->first();
        if (empty($checkParcel)) {
            $Parcels = Parcels::where(['id' => $parcelId])->update(['deliver_address' => $request->input('deliver_address'), 'parcelphoto' => $photo, 'deliveredTo' => $deliveredTo, 'delivered_latitude' => $delivered_latitude, 'delivered_longitude' => $delivered_longitude, 'parcelDeliverdDate' => date('Y-m-d'), 'status' => '2']);
            if ($Parcels) {
                return response()->json([
                    'status' => $this->successStatus,
                    'message' => 'Parcel Deliverd Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => $this->notfound,
                    'message' => 'Parcel not found',
                ]);
            }
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'Parcel already Updated',
            ]);
        }
    }

    public function undeliverParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parcelId' => 'required',
        ]);
        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }
        $parcelId = $request->input('parcelId');
        $checkParcel = Parcels::whereId($parcelId)->where('status', '1')->first();
        if (empty($checkParcel)) {
            $Parcels = Parcels::where(['id' => $parcelId])->update(['deliver_address' => null, 'parcelphoto' => null, 'deliveredTo' => null, 'delivered_latitude' => null, 'delivered_longitude' => null, 'parcelDeliverdDate' => date('Y-m-d'),'status' => '1']);
            
            if ($Parcels) {
                return response()->json([
                    'status' => $this->successStatus,
                    'message' => 'Parcel Deliverd Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => $this->notfound,
                    'message' => 'Parcel not found',
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Parcel already Updated',
            ]);
        }
    }

    public function allParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_id'      => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $shipId = $request->input('shift_id');
        $Parcels = Parcels::where('shiftId', $shipId)->with(['getParcelImage'])->get();
        $shipDetail = Shift::select('id', 'startlatitude', 'startlongitude', 'endlatitude', 'endlongitude', 'startaddress', 'endaddress')->whereId($shipId)->first();
        if ($Parcels) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
                'parcelImage' => env('PAREL_IMAGE'),
                'data' => $Parcels,
                'location' => $shipDetail,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function updateParcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parcelId'      => 'required|integer',
            'scanParcel'    => 'required',
            'location'      => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $parcelId = $request->input('parcelId');
        $parcelData = [
            'scanParcel' => $request->scanParcel,
            'location'   => $request->location,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'receiverName' => $request->receiverName??null,
        ];
        Parcels::whereId($parcelId)->update($parcelData);
        $parcelIamge = $request->file('parcelIamge');
        if ($parcelIamge) {
            $packageImage = json_decode(json_encode($parcelIamge));
            if ($packageImage) {
                $hgcount = count($packageImage);
            } else {
                $hgcount = 0;
            }
            DB::table('addparcelimages')->where('parcelId', $parcelId)->delete();

            for ($i = 0; $i < $hgcount; $i++) {
                $items = null;
                if ($request->hasFile('parcelIamge')) {
                    $image = $request->file('parcelIamge')[$i];
                    $dateFolder = 'driver/parcel';
                    $items = ImageController::upload($image, $dateFolder);
                }
                $packageItem = [
                    'parcelId'    => $parcelId,
                    'parcelImage' => $items,
                ];
                DB::table('addparcelimages')->insert($packageItem);
            }
        }

        return response()->json([
            'status' => $this->successStatus,
            'message' => 'Parcel Updated Successfully',
        ]);
    }

    public function searchLocation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'location'      => 'required',
            'shipId'  => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $location = $request->input('location');
        $shipId = $request->input('shipId');
        $Parcels = Parcels::select('id', 'location', 'latitude', 'longitude', 'sorting')->orderBy('sorting', 'ASC')->where('driverId', $this->driverId)->where('shiftId', $shipId)->Where('location', 'like', "%{$location}%")->get();

        if ($Parcels) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
                'data' => $Parcels,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function routeOptimization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sort'  => 'required',
            'shift_id'  => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $sortId = $request->input('sort');
        $sortingType = json_decode(json_encode($sortId));
        foreach ($sortingType as $sortOrder => $id) {
            $menu = Parcels::find($id);
            $menu->sorting = $sortOrder + 1;
            $menu->save();
        }
        $driverId = auth('driver')->user()->id;
        $Parcels = Parcels::select('id', 'receiverName', 'location', 'latitude', 'longitude', 'sorting')->orderBy('sorting', 'asc')->get();
        $shift = Shift::whereId($request->shift_id)->where('driverId', $driverId)->update(['optShift' => '1']);

        return response()->json([
            'status' => $this->successStatus,
            'message' => 'Success',
            'data' => $Parcels,
        ]);
    }

    public function calculateShiftHoursWithMinutes($startDate, $endDate)
    {

        $dayMinutes = 0;
        $nightMinutes = 0;
        $saturdayMinutes = 0;
        $sundayMinutes = 0;

        // while ($startDate < $endDate) {
        //     $currentHour = date('H', $startDate);
        //     $currentMinute = date('i', $startDate);

        //     if (date('N', $startDate) < 6 && ($currentHour >= 4 && $currentHour <= 17)) {
        //         if($currentHour == 17)
        //         {
        //           if($currentMinute < 59){
        //               $dayMinutes++;
        //           }
        //         } else {
        //             $dayMinutes++;
        //         }
        //     } elseif (date('N', $startDate) < 6 && ($currentHour >= 18 || $currentHour <= 3)) {
        //         if ($currentHour == 3) {
        //             if ($currentMinute < 59) {
        //                 $nightMinutes++;
        //             }
        //         }

        //         else if($currentHour == 23){
        //             $nextDay = strtotime('+1 minute', $startDate);
        //             if (date('N', $nextDay) == 6 &&  $currentMinute < 59) {
        //                 $nightMinutes++;
        //             } else if (date('N', $nextDay) <= 5) {
        //                 $nightMinutes++;
        //             }
        //         }

        //          else {
        //             $nightMinutes++;
        //         }
        //     } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 6) { // Saturday
        //         if ($currentHour == 23) {
        //             if ($currentMinute < 59) {
        //                 $saturdayMinutes++;
        //             }
        //         }  else {
        //             $saturdayMinutes++;
        //         }
        //     } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 7) { // Sunday
        //         if ($currentHour == 23) {
        //             if ($currentMinute < 59) {
        //                 $sundayMinutes++;
        //             }
        //         }  else {
        //             $sundayMinutes++;
        //         }
        //     }

        //     $startDate = strtotime('+1 minute', $startDate);
        // }

        while ($startDate < $endDate) {
            $currentHour = date('H', $startDate);
            $currentMinute = date('i', $startDate);

            if (date('N', $startDate) < 6 && ($currentHour >= 4 && $currentHour < 18)) {
                $dayMinutes++;
            } elseif (date('N', $startDate) < 6 && ($currentHour >= 18 || $currentHour < 4)) {
                $nightMinutes++;
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 6) { // Saturday
                $saturdayMinutes++;
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 7) { // Sunday
                $sundayMinutes++;
            }

            $startDate = strtotime('+1 minute', $startDate);
        }

        return [
            'dayHours' => floor($dayMinutes / 60),
            'dayMinutes' => $dayMinutes % 60 < 10 ? '0' . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60, 2),
            'dayTotal' => number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60, 2), 2),

            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => $nightMinutes % 60 < 10 ? '0' . ($nightMinutes % 60) : $nightMinutes % 60,
            'nightMinutesNew' => round(floor($nightMinutes % 60) / 60, 2),
            'nightTotal' => number_format(floor($nightMinutes / 60) + round(floor($nightMinutes % 60) / 60, 2), 2),

            'saturdayHours' => floor($saturdayMinutes / 60),
            'saturdaMinutes' => $saturdayMinutes % 60,
            'saturdayMinutesNew' => round(floor($saturdayMinutes % 60) / 60, 2),
            'totalSaturdayHours' => number_format(floor($saturdayMinutes / 60) + round(floor($saturdayMinutes % 60) / 60, 2), 2),

            'sundayHours' => floor($sundayMinutes / 60),
            'sundayMinutes' => $sundayMinutes % 60,
            'sundayMinutesNew' => round(floor($sundayMinutes % 60) / 60, 2),
            'totalSundayHours' => number_format(floor($sundayMinutes / 60) + round(floor($sundayMinutes % 60) / 60, 2), 2),

        ];
    }

    public function finishShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shiftId' => 'required',
            'odometerStartReading' => 'required',
            'odometerEndReading' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'parcelsTaken' => 'required',
            'parcelsDelivered' => 'required',
            // "addPhoto" => "required"
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $getClientID = Shift::whereId($request->shiftId)->first()->client ?? '';
        $query = Shift::where('id', $request->shiftId);

        $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientCharge' => function ($query) use ($getClientID) {
            $query->where('clientId', $getClientID);
        }])->first();

        $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();

        $startDate = $request->startDate . ' ' . $request->startTime;
        $endDate = $request->endDate . ' ' . $request->input('endTime');
        $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
        $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');
        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        $dayStartTime = Carbon::parse($start_date);
        $nightEndTime = Carbon::parse($end_date);
        $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);

        $dayHr = $result['dayTotal'];
        $nightHr = $result['nightTotal'];
        $saturdayHrs = $result['totalSaturdayHours'];
        $sundayHrs = $result['totalSundayHours'];
        $weekendHours = $saturdayHrs + $sundayHrs;

        $extra_per_hour_rate = $data['shiftView']->getDriverName->extra_per_hour_rate;

        if ($data['shiftView']) {
            $finishshift = Finishshift::where('shiftId', $request->shiftId)->first();
            if ($finishshift) {
                return response()->json([
                    'status' => $this->successStatus,
                    'message' => 'This Shift is already finished',
                ]);
            } else {

                $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';

                if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
                    if (!empty($dayHr)) {
                        $dayShiftwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableDay + $extra_per_hour_rate;
                        $dayShift = $dayShiftwithExtra * $dayHr;
                        $priceOverRideStatus = '0';
                        $dayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableDays + $extra_per_hour_rate;
                        $dayShiftCharge = $dayShiftChargewithExtra * $dayHr ?? 0;
                    }

                    if (!empty($nightHr)) {
                        $nightShiftwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableNight + $extra_per_hour_rate;
                        $nightShift = $nightShiftwithExtra * $nightHr ?? 0;
                        $priceOverRideStatus = '0';
                        $nightShiftChargewithExtra = $data['shiftView']->getClientCharge->ourlyRateChargeableNight + $extra_per_hour_rate;
                        $nightShiftCharge = $nightShiftChargewithExtra * $nightHr;
                    }

                    if (!empty($saturdayHrs)) {
                        $saturdayHrwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday + $extra_per_hour_rate;
                        $saturdayHr = $saturdayHrwithExtra * $saturdayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $saturdayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday + $extra_per_hour_rate;
                        $saturdayShiftCharge = $saturdayShiftChargewithExtra * $saturdayHrs;
                    }

                    if (!empty($sundayHrs)) {
                        $sundayHrwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableSunday + $extra_per_hour_rate;
                        $sundayHr = $sundayHrwithExtra * $sundayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $sundayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday + $extra_per_hour_rate;
                        $sundayShiftCharge = $sundayShiftChargewithExtra * $sundayHrs;
                    }

                    $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;

                    $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                    Shift::where('id', $request->shiftId)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                    DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver
                    DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin
                    // is Driver Payable
                }

                DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver

                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                Shift::where('id', $request->shiftId)->update(['chageAmount' => $totalChargeDay]);
                DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin

                $totalHr = $dayHr + $nightHr;

                $driverPay = Client::where('id', $data['shiftView']->client)->first();
                $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
                Client::where('id', $data['shiftView']->client)->update(['driverPay' => $driverIncome]);

                $adminCharge = Client::where('id', $data['shiftView']->client)->first();
                $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
                Client::where('id', $data['shiftView']->client)->update(['adminCharge' => $chargeAdmin]);

                Shift::whereId($request->shiftId)->update(['finishStatus' => '2', 'parcelsToken' => $request->parcelsTaken]);

                if ($request->file('addPhoto') != '') {
                    $image = $request->file('addPhoto');
                    $dateFolder = 'driver/parcel/finishParcel';
                    $items = ImageController::upload($image, $dateFolder);
                } else {
                    $items = '';
                }

                Shift::whereId($request->shiftId)->update(['finishStatus' => '2']);

                $Parcel = new Finishshift();
                $Parcel->driverId = $this->driverId;
                $Parcel->shiftId = $request->shiftId;
                $Parcel->odometerStartReading = $request->odometerStartReading;
                $Parcel->odometerEndReading = $request->odometerEndReading;
                $Parcel->dayHours = $dayHr;
                $Parcel->nightHours = $nightHr;
                $Parcel->saturdayHours = $saturdayHrs;
                $Parcel->sundayHours = $sundayHrs;
                $Parcel->weekendHours = $weekendHours ?? 0;
                $Parcel->totalHours = $totalHr ?? 0;
                $Parcel->startDate = $request->startDate;
                $Parcel->endDate = $request->endDate;
                $Parcel->startTime = $dayStartTime->format('H:i');
                $Parcel->endTime = $nightEndTime->format('H:i');
                $Parcel->parcelsTaken = $request->parcelsTaken??0;
                $Parcel->parcelsDelivered = $request->parcelsDelivered;
                $Parcel->addPhoto = $items;
                $Parcel->save();

                if ($Parcel) {
                    return response()->json([
                        'status' => $this->successStatus,
                        'message' => 'Shift Finished Successfully',
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'Shift Id Not exist',
            ]);
        }
    }
}
