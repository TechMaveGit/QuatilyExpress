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
                'parcelImage' => asset(env('STORAGE_URL')),
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
            $photo = null;
        }

        $checkParcel = Parcels::whereId($parcelId)->where('status', '2')->first();
        if (empty($checkParcel)) {
            $Parcels = Parcels::where(['id' => $parcelId])->update(['deliver_address' => $request->input('deliver_address'), 'parcelphoto' => $photo, 'deliveredTo' => $deliveredTo, 'delivered_latitude' => $delivered_latitude, 'delivered_longitude' => $delivered_longitude, 'parcelDeliverdDate' => date('Y-m-d H:i:s'), 'status' => '2']);
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
            $Parcels = Parcels::where(['id' => $parcelId])->update(['deliver_address' => null, 'parcelphoto' => null, 'deliveredTo' => null, 'delivered_latitude' => null, 'delivered_longitude' => null, 'parcelDeliverdDate' => null,'status' => '1']);
            
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
                'parcelImage' => asset(env('STORAGE_URL')),
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
        $start_date = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($endDate)->format('Y-m-d H:i:s');
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

        $dayShift = '0';
        $nightShift = '0';
        $sundayHr = '0';
        $saturdayHr = '0';
        $dayShiftCharge = '0';
        $nightShiftCharge = '0';
        $saturdayShiftCharge = '0';
        $sundayShiftCharge = '0';
        $priceOverRideStatus = '0';
        $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();

        $extra_per_hour_rate = $data['shiftView']->getDriverName->extra_per_hour_rate;

        if ($data['shiftView']) {
            $finishshift = Finishshift::where('shiftId', $request->shiftId)->first();
            // if ($finishshift) {
            //     return response()->json([
            //         'status' => $this->successStatus,
            //         'message' => 'This Shift is already finished',
            //     ]);
            // } else {

                $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';

                if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
                    if (!empty($dayHr)) {
                        if (empty($priceCompare)) {
                            $dayShift = (($clientRates->hourlyRatePayableDay??0)+$extra_rate_per_hour) * $dayHr;
                            $priceOverRideStatus = '0';
                            $dayShiftCharge = ($clientRates->hourlyRateChargeableDays??0) * $dayHr ?? 0;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                                $dayShift = (($clientRates->hourlyRatePayableDay??0)+$extra_rate_per_hour) * $dayHr ?? 0;
                                $priceOverRideStatus = '0';
                                $dayShiftCharge = ($clientRates->hourlyRateChargeableDays??0) * $dayHr ?? 0;
                            } else {
                                $priceComparehourlyRatePayableDays = !empty($priceCompare->hourlyRatePayableDays) ? $priceCompare->hourlyRatePayableDays : 1;
                                $dayShift = $priceComparehourlyRatePayableDays * $dayHr;
                                $priceOverRideStatus = '1';
                                $dayShiftCharge = ($clientRates->hourlyRateChargeableDays??0) * $dayHr ?? 0;
                            }
                        }
                    }
                    if (!empty($nightHr)) {
                        if (empty($priceCompare)) {
                            $nightShift = (($clientRates->hourlyRatePayableNight??0)+$extra_rate_per_hour) * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $nightShiftCharge = ($clientRates->ourlyRateChargeableNight??0) * $nightHr;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableNight) {
                                $nightShift = (($clientRates->hourlyRatePayableNight??0)+$extra_rate_per_hour) * $nightHr ?? 0;
                                $priceOverRideStatus = '0';
                                $nightShiftCharge = ($clientRates->ourlyRateChargeableNight??0) * $nightHr;
                            } else {
                                $priceComparehourlyRatePayableNight = !empty($priceCompare->hourlyRatePayableNight) ? $priceCompare->hourlyRatePayableNight : '1';
                                $nightShift = ($priceComparehourlyRatePayableNight+$extra_rate_per_hour) * $nightHr;
                                $priceOverRideStatus = '1';
                                $nightShiftCharge = ($clientRates->ourlyRateChargeableNight??0) * $nightHr;
                            }
                        }
                    }
                    if (!empty($saturdayHrs)) {
                        if (empty($priceCompare)) {
                            $saturdayHr = (($clientRates->hourlyRatePayableSaturday??0)+$extra_rate_per_hour) * $saturdayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $saturdayShiftCharge = ($clientRates->hourlyRateChargeableSaturday??0) * $saturdayHrs;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                                $saturdayHr = (($clientRates->hourlyRatePayableSaturday??0)+$extra_rate_per_hour) * $saturdayHrs ?? 0;
                                $priceOverRideStatus = '0';
                                $saturdayShiftCharge = ($clientRates->hourlyRateChargeableSaturday??0) * $saturdayHrs;
                            } else {
                                $saturdayHr = ($priceCompare->hourlyRatePayableSaturday+$extra_rate_per_hour) * $saturdayHrs;
                                $priceOverRideStatus = '1';
                                $saturdayShiftCharge = ($clientRates->hourlyRateChargeableSaturday??0) * $saturdayHrs;
                            }
                        }
                    }
                    $floatValue = $sundayHrs;
                    $intValue = (int) $floatValue;
                    if (!empty($intValue)) {
                        if (empty($priceCompare)) {
                            $sundayHr = (($clientRates->hourlyRatePayableSunday??0)+$extra_rate_per_hour) * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $sundayShiftCharge = ($clientRates->hourlyRateChargeableSunday??0) * $sundayHrs;
                        } else {
                            if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                                $sundayHr = (($clientRates->hourlyRatePayableSunday??0)+$extra_rate_per_hour) * $sundayHrs ?? 0;
                                $priceOverRideStatus = '0';
                                $sundayShiftCharge = ($clientRates->hourlyRateChargeableSunday??0) * $sundayHrs;
                            } else {
                                $sundayHr = ($priceCompare->hourlyRatepayableSunday+$extra_rate_per_hour) * $sundayHrs;
                                $priceOverRideStatus = '1';
                                $sundayShiftCharge = ($clientRates->hourlyRateChargeableSunday??0) * $sundayHrs;
                            }
                        }
                    }
                }

                $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr+(float)$request->input('fuelLevyPayable',0)+(float)$request->input('extraPayable',0);
                
                Shift::where('id', $id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge+(float)$request->input('fuelLevyChargeable250',0)+(float)$request->input('fuelLevyChargeable',0)+(float)$request->input('fuelLevyChargeable400',0)+(float)$request->input('extraChargeable',0);
                // dd($dayShiftCharge , $nightShiftCharge , $saturdayShiftCharge , $sundayShiftCharge,(float)$request->input('fuelLevyChargeable250',0),(float)$request->input('amountChargeablePerService',0),(float)$request->input('fuelLevyChargeable',0),(float)$request->input('fuelLevyChargeable400',0),(float)$request->input('extraChargeable',0));
                Shift::where('id', $id)->update(['chageAmount' => $totalChargeDay]);
                $totalHr = $data = $dayHr + $nightHr;
                $driverPay = Client::where('id', $getClientID)->first();
                $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
                Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);
                $adminCharge = Client::where('id', $getClientID)->first();
                $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
                Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);
                $existingFinishshiftId = $id;

                DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver

                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                Shift::where('id', $request->shiftId)->update(['chageAmount' => $totalChargeDay]);
                DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin


                Shift::whereId($request->shiftId)->update(['finishStatus' => '2', 'parcelsToken' => $request->parcelsTaken]);

                if ($request->file('addPhoto') != '') {
                    $image = $request->file('addPhoto');
                    $dateFolder = 'driver/parcel/finishParcel';
                    $items = ImageController::upload($image, $dateFolder);
                } else {
                    $items = null;
                }

                Shift::whereId($request->shiftId)->update(['finishStatus' => '2','odometer'=>$request->odometerStartReading]);

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
                $Parcel->startDate = date('Y-m-d',strtotime($request->startDate));
                $Parcel->endDate =  date('Y-m-d',strtotime($request->endDate));
                $Parcel->startTime = date('H:i:s',strtotime($request->startTime)); 
                $Parcel->endTime =  date('H:i:s',strtotime($request->endTime)); 
                $Parcel->submitted_at =  $request->finishAt ? date('Y-m-d H:i:s',strtotime($request->finishAt)):date('Y-m-d H:i:s');
                $Parcel->parcelsTaken = $request->parcelsTaken??0;
                $Parcel->parcelsDelivered = $request->parcelsDelivered;
                $Parcel->addPhoto = $items;
                $Parcel->save();

                
                if ($Parcel) {
                    DB::table('shiftMonetizeInformation')->insert(['amountPayablePerService'=>$totalPayShiftAmount,'totalPayable'=>$totalPayShiftAmount,'amountChargeablePerService'=>$totalChargeDay,'totalChargeable'=>$totalChargeDay]);
                    return response()->json([
                        'status' => $this->successStatus,
                        'message' => 'Shift Finished Successfully',
                    ]);
                }
            // }
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'Shift Id Not exist',
            ]);
        }
    }
}
