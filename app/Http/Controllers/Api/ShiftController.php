<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Alldropdowns;
use App\Models\Client;
use App\Models\Clientbase;
use App\Models\Clientcenter;
use App\Models\Clientrate;
use App\Models\Finishshift;
use App\Models\rego;
use App\Models\Shift;
use App\Models\States;
use App\Models\Type;
use App\Models\Vehical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public $successStatus = 200;
    public $notfound = 404;
    public $unauthorisedStatus = 400;
    public $internalServererror = 500;

    protected $driverId = '';

    public function __construct(Request $request)
    {
        $this->driverId = auth('driver')->user()->id ?? '';
    }

    public function addShift(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'state'          => 'required|integer',
            'client'         => 'required|integer',
            'costCentre'     => 'required|integer',
            'base'           => 'required',
            'vehicleType'    => 'required|integer',
            //    "rego"           => "required",
            'odometer'       => 'required',
            'parcelsToken'   => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        if ($request->input('newRego')) {
            $vehicle = new Vehical();
            $vehicle->vehicalType = $request->input('vehicleType');
            $vehicle->rego = $request->input('newRego');
            $vehicle->odometer = $request->input('odometer');
            $vehicle->driverResponsible = $this->driverId;
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
        $shify->vehicleType = $request->vehicleType;
        $shify->rego = $rego;
        $shify->odometer = $request->odometer;
        $shify->scanner_id = $request->scanner_id;
        $shify->finishStatus = '1';
        $shify->parcelsToken = $request->parcelsToken;
        $shify->shiftStartDate = date('Y-m-d H:i');
        $shify->save();

        if ($shify) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Driver Shift Added Successfully',
            ]);
        }
    }

    public function trackLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shiftid'     => 'required|integer',
            'latitude'    => 'required',
            'longitude'   => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $data = [
            'driver_id'  =>  $this->driverId,
            'shiftid'    => $request->input('shiftid'),
            'latitude'   => $request->input('latitude'),
            'longitude'  => $request->input('longitude'),
        ];

        $inserData = DB::table('track_location')->insert($data);
        if ($inserData) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Location not added ',
            ]);
        }
    }

    public function trackLocationData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shiftid'     => 'required|integer',
            'latitude'    => 'required|array',
            'latitude.*'  => 'required',
            'longitude'   => 'required|array',
            'longitude.*'  => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $data = [];

        if ($request->latitude && !empty($request->latitude)) {
            foreach ($request->latitude as $kk=>$lat) {
                $data[] = [
                    'driver_id'  =>  $this->driverId,
                    'shiftid'    => $request->input('shiftid'),
                    'latitude'   => $lat,
                    'longitude'  => $request->longitude[$kk],
                ];
            }
        }

        $inserData = DB::table('track_location')->insert($data);
        if ($inserData) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Location not added ',
            ]);
        }
    }

    public function ok(Request $request)
    {

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $dayStartTime = Carbon::parse($startDate);
        $nightEndTime = Carbon::parse($endDate);

        // Calculate total hours between day and night
        $totalHours = $dayStartTime->floatDiffInHours($nightEndTime);
        // Define day and night start times
        $dayStart = $dayStartTime->copy();
        $nightStart = $nightEndTime->copy()->startOfDay()->hour(12);

        // Calculate day and night hours
        $dayHours = 0;
        $nightHours = 0;

        if ($dayStartTime < $nightEndTime) {
            $dayHours = min($totalHours, $nightStart->floatDiffInHours($dayStartTime));
            $nightHours = $totalHours - $dayHours;
        }

        $formattedDayStart = $dayStart->format('H:i');
        $formattedNightStart = $nightStart->format('H:i');

        // Output the results
        $data = [
            'start' => $dayStartTime->format('H:i'),
            'end' => $nightEndTime->format('H:i'),
        ];

        return $data;
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

    public function updateShiftTiming(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'shiftid'       => 'required|integer',
            'startDate' => 'required|date_format:Y-m-d H:i',
            'finishDate'   => 'required|date_format:Y-m-d H:i',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $startDate = $request->startDate;
        $endDate = $request->finishDate;

        $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
        $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');

        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);

        $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);

        $dayHr = $result['dayTotal'];
        $nightHr = $result['nightTotal'];
        $saturdayHrs = $result['totalSaturdayHours'];
        $sundayHrs = $result['totalSundayHours'];
        $weekend = $saturdayHrs + $sundayHrs;

        $dayShift = '0';
        $nightShift = '0';
        $sundayHr = '0';
        $saturdayHr = '0';
        $dayShiftCharge = '0';
        $nightShiftCharge = '0';
        $saturdayShiftCharge = '0';
        $sundayShiftCharge = '0';
        $priceOverRideStatus = '0';

        $id = $request->input('shiftid');
        $getClientID = Shift::whereId($id)->first()->client ?? '';
        if ($getClientID) {

            $query = Shift::where('id', $id);
            $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getDriverName',
                'getClientCharge' => function ($query) use ($getClientID) {
                    $query->where('clientId', $getClientID);
                },
            ])->first();

            $extra_per_hour_rate = $data['shiftView']->getDriverName->extra_per_hour_rate;

            if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {

                if (!empty($dayHr)) {
                    $dayShiftwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableDay + $extra_per_hour_rate;
                    $dayShift = $dayShiftwithExtra * $dayHr;
                    $priceOverRideStatus = '0';
                    $dayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableDays;
                    $dayShiftCharge = $dayShiftChargewithExtra * $dayHr ?? 0;
                }

                if (!empty($nightHr)) {
                    $nightShiftwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableNight + $extra_per_hour_rate;
                    $nightShift = $nightShiftwithExtra * $nightHr ?? 0;
                    $priceOverRideStatus = '0';
                    $nightShiftChargewithExtra = $data['shiftView']->getClientCharge->ourlyRateChargeableNight;
                    $nightShiftCharge = $nightShiftChargewithExtra * $nightHr;
                }

                if (!empty($saturdayHrs)) {
                    $saturdayHrwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday + $extra_per_hour_rate;
                    $saturdayHr = $saturdayHrwithExtra * $saturdayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $saturdayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday;
                    $saturdayShiftCharge = $saturdayShiftChargewithExtra * $saturdayHrs;
                }

                if (!empty($sundayHrs)) {
                    $sundayHrwithExtra = $data['shiftView']->getClientCharge->hourlyRatePayableSunday + $extra_per_hour_rate;
                    $sundayHr = $sundayHrwithExtra * $sundayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $sundayShiftChargewithExtra = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday;
                    $sundayShiftCharge = $sundayShiftChargewithExtra * $sundayHrs;
                }
            }

            $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;

            Shift::where('id', $id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);

            $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;

            Shift::where('id', $id)->update(['chageAmount' => $totalChargeDay]);
            $totalHr = $data = $dayHr + $nightHr;

            $driverPay = Client::where('id', $getClientID)->first();
            $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
            Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);

            $adminCharge = Client::where('id', $getClientID)->first();
            $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
            Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);

            $existingFinishshiftId = $id;
            if ($existingFinishshiftId) {
                $Parcel = Finishshift::where('shiftId', $existingFinishshiftId)->first();
                if ($Parcel) {
                    $Parcel->dayHours = $dayHr;
                    $Parcel->nightHours = $nightHr;
                    $Parcel->totalHours = $totalHr;
                    $Parcel->saturdayHours = $saturdayHrs;
                    $Parcel->sundayHours = $sundayHrs;
                    $Parcel->weekendHours = $weekend;
                    $Parcel->startDate = Carbon::parse($startDate)->format('Y-m-d');
                    $Parcel->endDate = Carbon::parse($endDate)->format('Y-m-d');
                    $Parcel->startTime = Carbon::parse($startDate)->format('H:i');
                    $Parcel->endTime = Carbon::parse($endDate)->format('H:i');
                    $Parcel->save();
                }
            }

            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Shift Time updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => "Shift'id is not exist",
            ]);
        }
    }

    public function missedShift(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'state'          => 'required|integer',
            'client'         => 'required|integer',
            'costCentre'     => 'required|integer',
            'vehicleType'    => 'required|integer',
            'scanner_id'     => 'required',
            'odometer_start_reading' => 'required',
            'odometer_finish_reading' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'parcelsToken' => 'required',
            'parcel_delivered' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

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
        $shify->finishStatus = '2';
        $shify->save();

        $getClientID = Shift::whereId($shify->id)->first()->client;
        $query = Shift::whereId($shify->id);
        $data['shiftView'] = $query->orderBy('id', 'DESC')->with(['getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getClientVehicleRates', 'getClientReportCharge' => function ($query) use ($getClientID) {
            $query->where('clientId', $getClientID);
        }])->first();

        $startDate = $request->start_date . ' ' . $request->start_time;
        $endDate = $request->end_date . ' ' . $request->input('end_time');
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
            // is Driver Payable
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
            $files = $request->file('missedImage');
            $destinationPath = 'public/assets/driver/parcel/finishParcel';
            $file_name = md5(uniqid()) . '.' . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $items = $file_name;
        } else {
            $items = '';
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
        $Parcel->startTime = $dayStartTime->format('H:i');
        $Parcel->endTime = $nightEndTime->format('H:i');
        $Parcel->parcelsTaken = $request->parcelsTaken;
        $Parcel->parcelsDelivered = $request->parcel_delivered;
        $Parcel->addPhoto = $items;
        $Parcel->save();

        if ($Parcel) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Missed Shift Added Successfully',
            ]);
        }
    }

    public function addLocation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'shiftId' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
            'type'   => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $id = $request->input('shiftId');
        $type = $request->input('type');

        if ($type == '0') {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $address = $request->input('address');
            $addLocation = Shift::whereId($id)->update(['startlatitude' => $latitude, 'startlongitude' => $longitude, 'startaddress' => $address]);
        }

        if ($type == '1') {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $address = $request->input('address');
            $addLocation = Shift::whereId($id)->update(['endlatitude' => $latitude, 'endlongitude' => $longitude, 'endaddress' => $address]);
        }

        if ($addLocation) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Location Added Successfully',
            ]);
        }
    }

    public function shiftStart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_id'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $driverId = auth('driver')->user()->id;
        $shift = Shift::whereId($request->shift_id)->where('driverId', $driverId)->update(['finishStatus' => '1', 'shiftStartDate' => date('Y-m-d H:i:s')]);

        if ($shift) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
                'note' => 'Shift Start Successfully',
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'Shift not found',
            ]);
        }
    }

    public function showShift(Request $request)
    {
        $driverId = auth('driver')->user()->id;
        // $query = Shift::select('id', 'rego', 'odometer', 'base', 'payAmount', 'parcelsToken', 'client', 'costCenter', 'finishStatus', 'optShift', 'state', 'created_at as createdDate', 'shiftStartDate', 'vehicleType', 'payAmount', 'startlatitude', 'startlongitude', 'endlatitude', 'endlongitude', 'startaddress', 'endaddress', 'scanner_id', 'created_at', 'updated_at')->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime,odometerStartReading,odometerEndReading,parcelsDelivered', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name');
        $query = Shift::select('id', 'shiftRandId', 'rego', 'odometer', 'parcelsToken', 'client', 'costCenter', 'finishStatus', 'state', 'vehicleType', 'shiftStartDate', 'base', 'scanner_id', 'created_at', 'updated_at');
        $state = $request->input('state');
        $clientId = $request->input('clientId');
        $status = $request->input('status');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($state) {
            $query = $query->Where('state', $state);
        }

        if ($clientId) {
            $query = $query->Where('client', $clientId);
        }

        if ($status) {
            $query = $query->Where('finishStatus', $status);
        }
        if ($status == '0') {
            $query = $query->Where('finishStatus', $status);
        }

        if ($startDate) {
            $query = $query->where('shiftStartDate', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('finishDate', '<=', $endDate);
        }

        $shifts = $query->orderBy('id', 'DESC')->where('driverId', $driverId)->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime,odometerStartReading,odometerEndReading,parcelsDelivered', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name')->withCount('getParcel')->get();
        foreach ($shifts as $shift) {
            $shift->ReportDetail = Finishshift::select('dayHours', 'nightHours', 'weekendHours', 'odometerStartReading', 'odometerEndReading')
                ->where('shiftid', $shift->id ?? '')
                ->first();

            $shift->ClientBase = Clientbase::select('id', 'base')
                ->where('id', $shift->base)
                ->first()->base ?? '';

            $shift->ClientRego = Vehical::select('id', 'rego')
                ->where('status', '1')
                ->where('id', $shift->rego)
                ->first()->rego ?? '';
        }

        $countShift = $shift?->count() ?? '0';
        if (!($countShift) == 0) {
            return response()->json([
                'status' => $this->successStatus,
                'countShift' => $countShift,
                'message' => 'Success',
                'data' => $shifts,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'countShift' => $countShift,
                'message' => 'not found',
            ]);
        }
    }

    public function shiftDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_id'          => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $driverId = auth('driver')->user()->id;

        $shift = Shift::select('id', 'rego', 'odometer', 'base', 'payAmount', 'parcelsToken', 'client', 'costCenter', 'finishStatus', 'optShift', 'state', 'created_at as createdDate', 'shiftStartDate', 'vehicleType', 'payAmount', 'startlatitude', 'startlongitude', 'endlatitude', 'endlongitude', 'startaddress', 'endaddress', 'scanner_id', 'created_at', 'updated_at')->whereId($request->shift_id)->where('driverId', $driverId)->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime,odometerStartReading,odometerEndReading,parcelsDelivered', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name')->first();

        $reportDetail = Finishshift::select('dayHours', 'nightHours', 'weekendHours', 'odometerStartReading', 'odometerEndReading')
        ->where('shiftId', $request->shift_id ?? '')
        ->first();

        $shift->ReportDetail = $reportDetail ?? '0';
        $shift->ClientBase = Clientbase::select('id', 'base')->where('id', $shift->base)->first()->base ?? '';
        if ($shift->finishStatus == '2') {
            $extra_rate_per_hour = $shift->getDriverName->extra_rate_per_hour ?? '0';
        } else {
            $extra_rate_per_hour = 0;
        }
        if ($shift->getFinishShift->dayHours ?? 0 != '0') {
            $dayammmm = ($shift->getClientCharge->hourlyRatePayableDay + $extra_rate_per_hour ?? 0) * ($shift->getFinishShifts->dayHours ?? 0);
        } else {
            $dayammmm = 0;
        }
        if ($shift->getFinishShift->nightHours ?? 0 != '0') {
            $nightamm = ($shift->getClientCharge->hourlyRatePayableNight + $extra_rate_per_hour ?? 0) * ($shift->getFinishShifts->nightHours ?? 0);
        } else {
            $nightamm = 0;
        }
        $saturday = 0;
        $sunday = 0;

        if ($shift->getFinishShift && $shift->getFinishShift->saturdayHours != '0') {
            $saturday = ($shift->getClientCharge->hourlyRatePayableSaturday + $extra_rate_per_hour ?? 0) * ($shift->getFinishShifts->saturdayHours ?? 0);
        }

        if ($shift->getFinishShift && $shift->getFinishShift->sundayHours != '0') {
            $sunday = ($shift->getClientCharge->hourlyRatePayableSunday + $extra_rate_per_hour ?? 0) * ($shift->getFinishShifts->sundayHours ?? 0);
        }
        $finalAmount = $saturday + $sunday;
        $payAmount = round($dayammmm, 2) + round($nightamm, 2) + round($finalAmount, 2);
        $updatedAmnt = round($shift->payAmount ?? 0, 2);
        if ($payAmount < $updatedAmnt) {
            $finalpayamnnt = $updatedAmnt;
        } else {
            $finalpayamnnt = $payAmount;
        }

        $shift->payAmount = "$finalpayamnnt";
        $shift->ClientRego = Vehical::select('id', 'rego')->where('status', '1')->where('id', $shift->rego)->first()->rego ?? '';
        if ($shift->ReportDetail == '0') {
            $shift->ReportDetail = null;
        }

        if ($shift) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Success',
                'data' => $shift,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function myShiftDetail(Request $request)
    {
        $driverId = auth('driver')->user()->id;
        $validator = Validator::make($request->all(), [
            'shift_id'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $shift = Shift::select('id', 'rego', 'odometer', 'parcelsToken', 'client', 'costCenter', 'finishStatus', 'state', 'status', 'vehicleType', 'startlatitude', 'startlongitude', 'endlatitude', 'endlongitude', 'startaddress', 'endaddress', 'created_at', 'updated_at')->whereId($request->shift_id)->where('driverId', $driverId)->with('getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getClientRate')->first();

        if ($shift) {
            return response()->json([
                'status' => $this->successStatus,

                'message' => 'Success',
                'data' => $shift,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function homePageShift(Request $request)
    {
        $driverId = auth('driver')->user()->id;
        $query = Shift::select('id', 'shiftRandId', 'rego', 'odometer', 'parcelsToken', 'client', 'costCenter', 'finishStatus', 'state', 'vehicleType', 'created_at', 'updated_at');
        $state = $request->input('state');
        $clientId = $request->input('clientId');
        $status = $request->input('status');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($state) {
            $query = $query->Where('state', $state);
        }

        if ($clientId) {
            $query = $query->Where('client', $clientId);
        }

        if ($status) {
            $query = $query->Where('status', $status);
        }

        if ($startDate) {
            $query = $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $shift = $query->orderBy('id', 'DESC')->where('driverId', $driverId)->whereIn('finishStatus', [0, 1, 2])->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name')->withCount('getParcel')->get();

        $countShift = $shift->count();
        if (!($countShift) == 0) {
            return response()->json([
                'status' => $this->successStatus,
                'countShift' => $countShift,
                'message' => 'Success',
                'data' => $shift,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'countShift' => $countShift,
                'message' => 'not found',
            ]);
        }
    }

    public function deleteShift(Request $request)
    {
        $driverId = auth('driver')->user()->id;

        $validator = Validator::make($request->all(), [
            'shift_id'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response['status'] = 400;
            $response['response'] = $validator->messages();

            return $response;
        }

        $shift = Shift::whereId($request->shift_id)->where('driverId', $driverId)->delete();
        if ($shift) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Shift Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function allDropDown(Request $request)
    {
        $alldropdown = Alldropdowns::get();
        $regoField = Vehical::select('id', 'rego as name', 'created_at')->where('status', '1')->get();

        $typeField = Type::select('id', 'name', 'status')->where('status', '1')->get();
        foreach ($typeField as $vehicals) {
            $vehicals->regoField = DB::table('vehicals')->select('id', 'rego')->where('status', '1')->where('vehicalType', $vehicals->id)->get();
        }

        if ($request->input('clientId')) {

            $getCostCenter = Clientcenter::select('id', 'clientId', 'name')->where('status', '1')->where('clientId', $request->input('clientId'))->get();
            foreach ($getCostCenter as $allgetCostCenter) {
                $allgetCostCenter->clientBase = Clientbase::select('id', 'base')->where('clientcentersid', $allgetCostCenter->id)->where('cost_center_name', $allgetCostCenter->name)->where('clientId', $request->input('clientId'))->get();
            }

            $getType = Clientrate::select('id', 'clientId', 'type')->with(['getClientType'])->where('clientId', $request->input('clientId'))->get();
            foreach ($getType as $vehicals) {
                $vehicals->regoField = DB::table('vehicals')->select('id', 'rego')->where('status', '1')->where('vehicalType', $vehicals->id)->get();
            }
        } else {
            $getCostCenter = [];
            $getType = [];
        }

        if ($alldropdown) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'All Dropdown Field',
                'note' => 'typeStatus field 1 is state, 2 is cost center',
                'data'   => $alldropdown,
                'regoField' => $regoField,
                'typeField' => $typeField,
                'getCostCenter' => $getCostCenter,
                'getType' => $getType,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function shiftStatus(Request $request)
    {
        $alldropdown = DB::table('shiftstatus')->where('status', '1')->get();
        if ($alldropdown) {
            return response()->json([
                'status' => $this->successStatus,
                'message' => 'Shift Status',
                'data'   => $alldropdown,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function filterMyShift(Request $request)
    {
        $driverId = auth('driver')->user()->id;

        $query = Shift::select('id', 'rego', 'odometer', 'parcelsToken', 'client', 'costCenter', 'status', 'state', 'vehicleType', 'created_at', 'updated_at');

        $state = $request->input('state');
        $clientId = $request->input('clientId');
        $status = $request->input('status');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($state) {
            $query = $query->Where('state', $state);
        }

        if ($clientId) {
            $query = $query->Where('client', $clientId);
        }

        if ($status) {
            $query = $query->Where('status', $status);
        }

        if ($startDate) {
            $query = $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $shift = $query->orderBy('id', 'DESC')->where('driverId', $driverId)->with('getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name')->get();
        $countShift = $shift->count();
        if ($shift) {
            return response()->json([
                'status' => $this->successStatus,
                'countShift' => $countShift,
                'message' => 'Success',
                'data' => $shift,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }

    public function allStates(Request $request)
    {
        $state = States::where('status', '1')->get();
        // dd($state);
        if ($state) {
            return response()->json([
                'status' => $this->successStatus,

                'message' => 'Success',
                'data' => $state,
            ]);
        } else {
            return response()->json([
                'status' => $this->notfound,
                'message' => 'not found',
            ]);
        }
    }
}
