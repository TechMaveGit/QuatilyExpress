<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Client;
use App\Models\Clientcenter;
use App\Models\Clientrate;
use App\Models\Finishshift;
use App\Models\Shift;
use App\Models\States;
use App\Models\Vehical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CommonApiController extends Controller
{
    protected $driverId;

    public function __construct()
    {
        $this->driverId = auth('driver')->user()->id ?? '';
    }

    public function CommonApi()
    {
        try {
            $main_array = [];
            $states = States::where('status', '1')->get();

            foreach ($states as $state) {
                $state_array = [];
                $state_array['id'] = $state->id;
                $state_array['name'] = $state->name;
                $state_array['shortName'] = $state->shortName;

                $clients = Client::select('id', 'name', 'shortName')->where('state', $state->id)->where('status', '1')->get();

                foreach ($clients as $client) {
                    $client_array = [];
                    $client_array['id'] = $client->id;
                    $client_array['name'] = $client->name;
                    $client_array['shortName'] = $client->shortName;

                    $costCenters = Clientcenter::select('id', 'clientId', 'name')->where('status', '1')->where('clientId', $client->id)->get();
                    $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->where('clientId', $client->id)->get();
                    foreach ($getType as $vehicals) {
                        $vehicals->regoField = DB::table('vehicals')->select('id', 'rego')->where('status', '1')->where('vehicalType', $vehicals->getClientType->id)->get();
                    }

                    foreach ($costCenters as $base) {
                        $base['clientBase'] = DB::table('clientbases')->select('id', 'base')->where('status', '1')->where('clientcentersid', $base->id)->get();
                    }

                    $client_array['cost_center'] = $costCenters;
                    $client_array['getType'] = $getType;

                    $state_array['clients'][] = $client_array;
                }

                $main_array[] = $state_array;
            }

            $vehicleRego = DB::table('vehicals')->select('id', 'rego')->get();

            $insepctiopnRego = DB::table('vehicals')
            ->select('id', 'rego')
            ->where('controlVehicle', '1')
            ->where('driverResponsible', $this->driverId)
            ->get();
            if (count($insepctiopnRego) <= 0) {
                $insepctiopnRego = $vehicleRego;
            }

            return response()->json([
                'status' => 200,
                'message' => 'Common Api',
                'data' => $main_array,
                'vehicleRego' => $vehicleRego,
                'insepctiopnRego' => $insepctiopnRego ?? [],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Something Went wrong',
                'data' => [],
            ]);
        }
    }

    public function completeShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state'                     => 'required|integer',
            'client'                    => 'required|integer',
            'costCentre'                => 'required|integer',
            'vehicleType'               => 'required|integer',
            'scanner_id'                => 'required',
            'odometer_start_reading'    => 'required',
            'odometer_finish_reading'   => 'required',
            'start_date'                => 'required',
            'end_date'                  => 'required',
            'start_time'                => 'required',
            'end_time'                  => 'required',
            'parcelsToken'              => 'required',
            'parcel_delivered'          => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        if ($request->shiftId == '-1') {
            if ($request->input('newRego')) {
                $vehicle = new Vehical();
                $vehicle->vehicalType = $request->input('vehicleType');
                $vehicle->rego = $request->input('newRego');
                $vehicle->save();
                $rego = $vehicle->id;
            } else {
                $rego = $request->rego;
            }

            $shify = new Shift();
            $shify->shiftRandId = rand('9999', '0000');
            $shify->driverId = $this->driverId;
            $shify->state = $request->state;
            $shify->client = $request->client;
            $shify->costCenter = $request->costCentre;
            $shify->base = $request->base;
            $shify->shiftStartDate = $request->start_date . ' ' . $request->start_time;
            $shify->vehicleType = $request->vehicleType;
            $shify->rego = $rego;
            $shify->odometer = $request->odometer_start_reading;
            $shify->scanner_id = $request->scanner_id;
            $shify->parcelsToken = $request->parcelsToken;
            $shify->comment = $request->comment;
            $shify->createdDate = $request->createdDate ? date('Y-m-d H:i:s',strtotime($request->createdDate)):date('Y-m-d H:i:s');
            $shify->finishStatus = '2';
            $shify->is_missed_shift = '1';
            $shify->save();

            $getClientID = Shift::whereId($shify->id)->first()->client;
            $query = Shift::whereId($shify->id);
            $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }])->first();

            $startDate = $request->start_date . ' ' . $request->start_time;
            $endDate = $request->end_date . ' ' . $request->input('end_time');
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

            $extra_per_hour_rate = $data['shiftView']->getDriverName->extra_per_hour_rate;

            $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';

            if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {

                if (!empty($dayHr)) {
                    $dayShiftwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableDay + $extra_per_hour_rate;
                    $dayShift = $dayShiftwithExtra * $dayHr;
                    $priceOverRideStatus = '0';
                    $dayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableDays;
                    $dayShiftCharge = $dayShiftChargewithExtra * $dayHr ?? 0;
                }

                if (!empty($nightHr)) {
                    $nightShiftwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableNight + $extra_per_hour_rate;
                    $nightShift = $nightShiftwithExtra * $nightHr ?? 0;
                    $priceOverRideStatus = '0';
                    $nightShiftChargewithExtra = $data['shiftView']->getClientReportCharge->ourlyRateChargeableNight;
                    $nightShiftCharge = $nightShiftChargewithExtra * $nightHr;
                }

                if (!empty($saturdayHrs)) {
                    $saturdayHrwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableSaturday + $extra_per_hour_rate;
                    $saturdayHr = $saturdayHrwithExtra * $saturdayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $saturdayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableSaturday;
                    $saturdayShiftCharge = $saturdayShiftChargewithExtra * $saturdayHrs;
                }

                if (!empty($sundayHrs)) {
                    $sundayHrwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableSunday + $extra_per_hour_rate;
                    $sundayHr = $sundayHrwithExtra * $sundayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $sundayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableSunday;
                    $sundayShiftCharge = $sundayShiftChargewithExtra * $sundayHrs;
                }

                $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
                $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                Shift::where('id', $shify->id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
                DB::table('clientcharge')->insert(['shiftId' => $shify->id, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver
                DB::table('clientcharge')->insert(['shiftId' => $shify->id, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin
            }

            // Client charage Amount
            Shift::where('id', $shify->id)->update(['chageAmount' => $totalChargeDay]);
            $totalHr = $data = $dayHr + $nightHr;
            // End client Charge Amount

            $driverPay = Client::where('id', $getClientID)->first();
            $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
            Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);

            $adminCharge = Client::where('id', $getClientID)->first();
            $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
            Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);

            Shift::whereId($shify->id)->update(['finishStatus' => '2']);

            if ($request->file('missedImage') != '') {
                $image = $request->file('missedImage');
                $dateFolder = 'driver/parcel/finishParcel';
                $items = ImageController::upload($image, $dateFolder);
            } else {
                $items = null;
            }

            $Parcel = new Finishshift();
            $Parcel->driverId = $this->driverId;
            $Parcel->shiftId = $shify->id;
            $Parcel->odometerStartReading = $request->odometer_start_reading;
            $Parcel->odometerEndReading = $request->odometer_finish_reading;
            $Parcel->dayHours = $dayHr;
            $Parcel->nightHours = $nightHr;
            $Parcel->saturdayHours = $saturdayHrs;
            $Parcel->sundayHours = $sundayHrs;
            $Parcel->weekendHours = $weekendHours ?? 0;
            $Parcel->totalHours = $totalHr ?? 0;
            $Parcel->startDate = $request->start_date;
            $Parcel->endDate = $request->end_date;
            $Parcel->startTime = $dayStartTime->format('H:i:s');
            $Parcel->endTime = $nightEndTime->format('H:i:s');
            $Parcel->submitted_at = $request->createdDate ? date('Y-m-d H:i:s',strtotime($request->createdDate)):date('Y-m-d H:i:s');
            $Parcel->parcelsTaken = $request->parcelsTaken;
            $Parcel->parcelsDelivered = $request->parcel_delivered;
            $Parcel->addPhoto = $items;
            $Parcel->save();

            if ($Parcel) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Shift Added Successfully',
                ]);
            }
        } else {
            $getClientID = Shift::whereId($request->shiftId)->first()->client ?? '';
            $query = Shift::where('id', $request->shiftId);
            $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }])->first();
            $startDate = $request->start_date . ' ' . $request->start_time;
            $endDate = $request->end_date . ' ' . $request->end_time;
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

            // dd($dayHr, $nightHr, $saturdayHrs,$sundayHrs,$weekendHours);

            $extra_per_hour_rate = $data['shiftView']->getDriverName->extra_per_hour_rate;

            if ($data['shiftView']) {
                $finishshift = Finishshift::where('shiftId', $request->shiftId)->first();
                if ($finishshift) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'This Shift is already finished',
                    ]);
                } else {

                    $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';

                    if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
                        if (!empty($dayHr)) {
                            $dayShiftwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableDay + $extra_per_hour_rate;
                            $dayShift = $dayShiftwithExtra * $dayHr;
                            $priceOverRideStatus = '0';
                            $dayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableDays + $extra_per_hour_rate;
                            $dayShiftCharge = $dayShiftChargewithExtra * $dayHr ?? 0;
                        }

                        if (!empty($nightHr)) {
                            $nightShiftwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableNight + $extra_per_hour_rate;
                            $nightShift = $nightShiftwithExtra * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $nightShiftChargewithExtra = $data['shiftView']->getClientReportCharge->ourlyRateChargeableNight + $extra_per_hour_rate;
                            $nightShiftCharge = $nightShiftChargewithExtra * $nightHr;
                        }

                        if (!empty($saturdayHrs)) {
                            $saturdayHrwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableSaturday + $extra_per_hour_rate;
                            $saturdayHr = $saturdayHrwithExtra * $saturdayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $saturdayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableSaturday + $extra_per_hour_rate;
                            $saturdayShiftCharge = $saturdayShiftChargewithExtra * $saturdayHrs;
                        }

                        if (!empty($sundayHrs)) {
                            $sundayHrwithExtra = $data['shiftView']->getClientReportCharge->hourlyRatePayableSunday + $extra_per_hour_rate;
                            $sundayHr = $sundayHrwithExtra * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $sundayShiftChargewithExtra = $data['shiftView']->getClientReportCharge->hourlyRateChargeableSunday + $extra_per_hour_rate;
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

                    // $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
                    Shift::where('id', $request->shiftId)->update(['chageAmount' => $totalChargeDay]);
                    DB::table('clientcharge')->insert(['shiftId' => $request->shiftId, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin

                    $totalHr = $dayHr + $nightHr;

                    $driverPay = Client::where('id', $data['shiftView']->client)->first();
                    $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
                    Client::where('id', $data['shiftView']->client)->update(['driverPay' => $driverIncome]);

                    $adminCharge = Client::where('id', $data['shiftView']->client)->first();
                    $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
                    Client::where('id', $data['shiftView']->client)->update(['adminCharge' => $chargeAdmin]);

                    Shift::whereId($request->shiftId)->update(['finishStatus' => '2']);
                    if ($request->file('missedImage') != '') {
                        $image = $request->file('missedImage');
                        $dateFolder = 'driver/parcel/finishParcel';
                        $items = ImageController::upload($image, $dateFolder);
                    } else {
                        $items = null;
                    }

                    Shift::whereId($request->shiftId)->update(['finishStatus' => '2']);

                    $Parcel = new Finishshift();
                    $Parcel->driverId = $this->driverId;
                    $Parcel->shiftId = $request->shiftId;
                    $Parcel->odometerStartReading = $request->odometer_start_reading;
                    $Parcel->odometerEndReading = $request->odometer_finish_reading;
                    $Parcel->dayHours = $dayHr;
                    $Parcel->nightHours = $nightHr;
                    $Parcel->saturdayHours = $saturdayHrs;
                    $Parcel->sundayHours = $sundayHrs;
                    $Parcel->weekendHours = $weekendHours ?? 0;
                    $Parcel->totalHours = $totalHr ?? 0;
                    $Parcel->startDate = $request->start_date;
                    $Parcel->endDate = $request->end_date;
                    $Parcel->startTime = $dayStartTime->format('H:i:s');
                    $Parcel->endTime = $nightEndTime->format('H:i:s');
                    $Parcel->submitted_at = $request->finishAt ? date('Y-m-d H:i:s',strtotime($request->finishAt)):date('Y-m-d H:i:s');
                    $Parcel->parcelsTaken = $request->parcelsTaken;
                    $Parcel->parcelsDelivered = $request->parcel_delivered;
                    $Parcel->addPhoto = $items;
                    $Parcel->save();

                    if ($Parcel) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Shift Finished Successfully',
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Shift Id Not exist',
                ]);
            }
        }
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
}
