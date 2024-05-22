<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Shift;
use App\Models\Vehical;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Tollexpense;
use App\Models\OperactionExp;
use App\Models\Clientrate;
use App\Models\Parcels;
use App\Models\Finishshift;
use App\Models\Clientcenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Homecontroller extends Controller
{
    public function index(Request $request)
    {
        // New first graph
        $getYear = $request->input('getYear');
        if (empty($getYear)) {
            $getYear = date('Y');
        } else {
            $getYear = $request->input('getYear');
        }
        $driver = $request->input('driverResponsible');
        $rego = $request->input('vehicleRego');
        for ($i = 1; $i <= 12; $i++) {
            $query = DB::table('clientcharge')->where('status', '1');
            if ($driver) {
                $query = $query->where('driverResponsible', $driver);
            }
            if ($rego) {
                $query = $query->where('rego', $rego);
            }
            $adminCharge[] = $query->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('amount');
            $qery2 = DB::table('clientcharge')->where('status', '0');
            if ($driver) {
                $qery2 = $qery2->where('driverResponsible', $driver);
            }
            $driverPay[] = $qery2->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('amount');
        }
        $firstGraphClientCharge =  $adminCharge;
        $firstGraphdriverPay3   =  $driverPay;
        
        $totalsum = array();
        for ($i = 1; $i <= 12; $i++) {

            $clientrate_sum = DB::table('clientrates')
            ->whereYear('created_at', $getYear)
            ->whereMonth('created_at', $i)
            ->select(DB::raw('SUM(driverEarning) as total_driver_earning, SUM(adminCharageAmount) as total_admin_charge'))
            ->first();
            $expenseReport[] = DB::table('expenses')->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('cost');
            $tollexpense[]   = DB::table('tollexpenses')->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('trip_cost');
            $operactionExp[] = DB::table('operaction_exps')->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('cost');
            $driverPayAmount[] = $clientrate_sum->total_driver_earning??0;
            $Clientrate[]    = $clientrate_sum->total_admin_charge??0;
        }
        $secondGraphOverAllExpense = array();
        $clientCharge = array();
        $secondClientrate = array();
        for ($i = 0; $i <= 11; $i++) {
            $secondGraphOverAllExpense[$i] = (int)($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i] + $driverPayAmount[$i]);
            $clientCharge[$i] = (int)($Clientrate[$i]);
            $secondClientrate[$i] = (int)($clientCharge[$i]) - ($secondGraphOverAllExpense[$i]);  // Profit and loss
            $totalsum[$i] = (int)($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i] + $driverPayAmount[$i] - $Clientrate[$i]);
        }

        $row = Shift::selectRaw("driverId")->groupBy("driverId")->get();
        $driverId[] = '';
        foreach ($row as $allDriver) {
            $driverId[] = $allDriver->driverId;
            $allDriver->pendingCount = shift::where('driverId', $allDriver->driverId)->where('finishStatus', '0')->count();
            $allDriver->doneCount = shift::where('driverId', $allDriver->driverId)->where('finishStatus', '1')->count();
            $allDriver->driverName = Driver::where('id', $allDriver->driverId)->first()->userName ?? 'N/A';
        }
        // Shift Report By Driver..................................... 1
        $driverName = Driver::whereIn('id', $driverId)->get();
        $data = null;
        foreach ($driverName as $allrow) {
            $data[] = $allrow->userName;
        }
        // End Shift Report By Driver............................... 1
        // Client Profit And Loss....................................... 2
        $clientName = Client::get();
        foreach ($clientName as $allClient) {
            $name[] = $allClient->name;
            $adminCharge[] = $allClient->adminCharge;
            $driverPay[] = $allClient->driverPay;
        }
        $clientName1  =  $name;
        $adminCharge2 =  $adminCharge;
        $driverPay3   =  $driverPay;
        // End Client Profit And Loss.................................. 2
        // Box Section
        $expenseReport = Expense::sum('cost');
        $tollexpense   = Tollexpense::sum('trip_cost');
        $operactionExp = OperactionExp::sum('cost');
        // End Box Section
        $data['totalDriver'] = Driver::count();
        $data['totalClient'] = Client::count();
        $data['totalVehicle'] = Vehical::count();
        $data['totalShift'] = Shift::count();
        $data['driverFilter'] = Driver::where('status', '1')->get();
        $data['totalRego'] = Vehical::select('id', 'rego')->get();
        // new design Box count section
        $data['driverPay'] = Client::sum('driverPay');
        $data['clientPay'] = Client::sum('adminCharge');
        $data['tollexpense'] = $tollexpense;
        // end box design section
        $data['check'] = '';
        $yearName = $request->input('getYear');
        $driverResponsible = $request->input('driverResponsible');
        $vehicleRego = $request->input('vehicleRego');
        $data['allRego'] = Vehical::orderBy('id', 'DESC');
        if ($yearName) {
            $data['allRego'] = $data['allRego']->whereYear('created_at', $yearName);
        }
        if ($driverResponsible) {
            $data['allRego'] = $data['allRego']->where('driverResponsible', $driverResponsible);
        }
        if ($vehicleRego) {
            $data['allRego'] = $data['allRego']->where('rego', $vehicleRego);
        }
        $data['allRego'] = $data['allRego']->with(['getShiftRego.getClientNm'])->get();
        // dd($data['allRego']);
        $list = '0';
        $roleId = Auth::guard('adminLogin')->user();
        if ($roleId->role_id !== 1) {
            $driverId = Driver::where('email', $roleId->email)->first()->id;
            $data['monthlyShift'] = Shift::where('driverId', $driverId)->count();
            $data['totalReceivedAmount'] = Shift::where('driverId', $driverId)->where('payAmount', $roleId->id)->sum('payAmount');
            $data['dayHours'] = Finishshift::where('driverId', $driverId)->sum('dayHours');
            $data['nightHours'] = Finishshift::where('driverId', $driverId)->sum('nightHours');
            $data['allSub'] = $data['dayHours'] + $data['nightHours'];
            $data['payShift'] = Shift::where('driverId', $driverId)->where('finishStatus', '=', '5')->count();
            $data['onboardDate'] = '';
        } else {
            $data['monthlyShift'] = '';
            $data['totalReceivedAmount'] = '';
            $data['totalHour'] = '';
            $data['paidShift'] = '';
            $data['onboardDate'] = '';
            $data['totalHours'] = '';
            $data['payShift'] = '';
        }
        $userId = Auth::guard('adminLogin')->user();
        $query = Shift::orderBy('id', 'DESC');
        if ($userId->role_id == '33') {
            $currentDate = now()->toDateString();
            $driverId = Driver::where('email', $userId->email)->first()->id;
            $query = $query->where('driverId', $driverId)->whereDate('created_at', '=', $currentDate)->whereIn('finishStatus', ['0', '1']);
        }
        $data['shift'] = $query->orderBy('id', 'DESC')->with('getClientName:id,name', 'getDriverName:id,userName', 'getVehicleType:id,name', 'getStateName:id,name', 'getFinishShift')->get();
        $data['state'] = DB::table('states')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['clientcenter'] = Clientcenter::select('id', 'name')->get();
        $data['clientbases'] = DB::table('clientbases')->select('id', 'base')->get();
        //   return $userData;
        return view('admin.dashboard.home', $data, compact('secondGraphOverAllExpense', 'clientCharge', 'secondClientrate', 'firstGraphClientCharge', 'firstGraphdriverPay3', 'yearName', 'driverResponsible', 'vehicleRego', 'expenseReport', 'Clientrate', 'tollexpense', 'operactionExp', 'totalsum', 'row', 'list', 'clientName1', 'adminCharge2', 'driverPay3'));
    }
    public function shiftStart(Request $request)
    {
        $shiftStart = $request->input('shiftId');
        $shift = Shift::whereId($shiftStart)->update(['finishStatus' => '1', 'shiftStartDate' => date("Y-m-d H:i:s")]);
        if ($shift) {
            return response()->json([
                'success' => '200',
                'message' => 'Start successfully.',
            ]);
        } else {
            return response()->json([
                'success' => '400',
                'message' => 'Not',
            ]);
        }
    }
    function calculateShiftHoursWithMinutes($startDate, $endDate)
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
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 6) {  // Saturday
                $saturdayMinutes++;
            } elseif ($currentHour >= 0 && $currentHour <= 23 && date('N', $startDate) == 7) {  // Sunday
                $sundayMinutes++;
            }
            $startDate = strtotime('+1 minute', $startDate);
        }
        return  [
            'dayHours' => floor($dayMinutes / 60),
            'dayMinutes' => $dayMinutes % 60 < 10 ? "0" . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60, 2),
            'dayTotal' => number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60, 2), 2),
            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => $nightMinutes % 60 < 10 ? "0" . ($nightMinutes % 60) : $nightMinutes % 60,
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
        if (request()->isMethod("post")) {
            $odometerStartReading = $request->odometerStartReading;
            $odometerEndReading = $request->odometerEndReading;
            $parcelsTaken = $request->parcelsToken;
            $parcelDelivered = $request->parcel_delivered;
            $shiftId = $request->shiftId;
            $shift = Shift::with([
                'getDriverName',
                'getStateName:id,name',
                'getClientName:id,name,shortName',
                'getCostCenter:id,name',
                'getVehicleType:id,name',
                'getFinishShifts',
                'getClientVehicleRates',
                'getClientCharge' => function ($query) use ($shiftId) {
                    $query->where('clientId', Shift::whereId($shiftId)->value('client'));
                },
            ])->where('id', $shiftId)->orderBy('id', 'DESC')->first();
            $extra_per_hour_rate = $shift->getDriverName->extra_per_hour_rate;
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
            $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');
            $startDate    = strtotime($start_date);
            $endDate      = strtotime($end_date);
            $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);
            $dayHr       =   $result['dayTotal'];
            $nightHr     =   $result['nightTotal'];
            $saturdayHrs =   $result['totalSaturdayHours'];
            $sundayHrs   =   $result['totalSundayHours'];
            $weekend     =   $saturdayHrs + $sundayHrs;
            $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';
            if (!empty($dayHr) || !empty($nightHr)   || !empty($saturdayHrs)   || !empty($sundayHrs)) {
                if (!empty($dayHr)) {
                    $dayShiftwithExtra = $shift->getClientCharge->hourlyRatePayableDay + $extra_per_hour_rate;
                    $dayShift =  $dayShiftwithExtra * $dayHr;
                    $priceOverRideStatus = '0';
                    $dayShiftChargewithExtra = $shift->getClientCharge->hourlyRateChargeableDays + $extra_per_hour_rate;
                    $dayShiftCharge = $dayShiftChargewithExtra * $dayHr ?? 0;
                }
                if (!empty($nightHr)) {
                    $nightShiftwithExtra = $shift->getClientCharge->hourlyRatePayableNight + $extra_per_hour_rate;
                    $nightShift = $nightShiftwithExtra * $nightHr ?? 0;
                    $priceOverRideStatus = '0';
                    $nightShiftChargewithExtra = $shift->getClientCharge->ourlyRateChargeableNight + $extra_per_hour_rate;
                    $nightShiftCharge =  $nightShiftChargewithExtra  * $nightHr;
                }
                if (!empty($saturdayHrs)) {
                    $saturdayHrwithExtra = $shift->getClientCharge->hourlyRatePayableSaturday + $extra_per_hour_rate;
                    $saturdayHr = $saturdayHrwithExtra * $saturdayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $saturdayShiftChargewithExtra = $shift->getClientCharge->hourlyRateChargeableSaturday + $extra_per_hour_rate;
                    $saturdayShiftCharge = $saturdayShiftChargewithExtra * $saturdayHrs;
                }
                if (!empty($sundayHrs)) {
                    $sundayHrwithExtra = $shift->getClientCharge->hourlyRatePayableSunday + $extra_per_hour_rate;
                    $sundayHr = $sundayHrwithExtra * $sundayHrs ?? 0;
                    $priceOverRideStatus = '0';
                    $sundayShiftChargewithExtra = $shift->getClientCharge->hourlyRateChargeableSunday  + $extra_per_hour_rate;
                    $sundayShiftCharge = $sundayShiftChargewithExtra * $sundayHrs;
                }
            }
            $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
            Shift::where('id', $shiftId)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);
            DB::table('clientcharge')->insert(['shiftId' => $shiftId, 'amount' => $totalPayShiftAmount, 'status' => '0']);  // O is pay to Driver
            $totalChargeDay = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;
            Shift::where('id', $shiftId)->update(['chageAmount' => $totalChargeDay]);
            DB::table('clientcharge')->insert(['shiftId' => $shiftId, 'amount' => $totalChargeDay, 'status' => '1']); // 1 is charge to admin
            $totalHr = $dayHr + $nightHr;
            $driverPay = Client::where('id', $shift->client)->first();
            $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
            Client::where('id', $shift->client)->update(['driverPay' => $driverIncome]);
            $adminCharge = Client::where('id', $shift->client)->first();
            $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
            Client::where('id', $shift->client)->update(['adminCharge' => $chargeAdmin]);
            Shift::whereId($shiftId)->update(['finishStatus' => '2']);
            $files = $request->file('addPhoto');
            $destinationPath = 'assets/driver/parcel/finishParcel';
            $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $items = $file_name ?? '0';
            $userId = Auth::guard('adminLogin')->user();
            $driverId = Driver::where('email', $userId->email)->first()->id;
            $finishShift = new Finishshift();
            $finishShift->driverId = $driverId;
            $finishShift->shiftId = $shiftId;
            $finishShift->odometerStartReading = $odometerStartReading;
            $finishShift->odometerEndReading = $odometerEndReading;
            $finishShift->dayHours = $dayHr;
            $finishShift->nightHours = $nightHr;
            $finishShift->totalHours = $totalHr;
            $finishShift->saturdayHours = $saturdayHrs;
            $finishShift->sundayHours = $sundayHrs;
            $finishShift->weekendHours = $weekend;
            $finishShift->startDate = Carbon::parse($startDate)->format('Y-m-d');
            $finishShift->endDate = Carbon::parse($endDate)->format('Y-m-d');
            $finishShift->startTime      = Carbon::parse($startDate)->format('H:i');
            $finishShift->endTime      = Carbon::parse($endDate)->format('H:i');
            $finishShift->parcelsTaken = $parcelsTaken;
            $finishShift->parcelsDelivered = $parcelDelivered;
            $finishShift->addPhoto = $items;
            $finishShift->save();
            return redirect()->route('admin.dashboard')->with('message', 'Shift Finished Successfully');
        }
    }
    private function calculateShift($priceCompare, $payableRate, $chargeableRate, $hours)
    {
        $shift = '0';
        $shiftCharge = '0';
        $priceOverRideStatus = '0';
        if (is_numeric($priceCompare) && $priceCompare < $payableRate) {
            $shift = $payableRate * $hours;
            $priceOverRideStatus = '0';
            $shiftCharge = $chargeableRate * $hours;
        } else {
            $priceCompareRate = is_numeric($priceCompare) ? $priceCompare : '1';
            $shift = $priceCompareRate * $hours;
            $priceOverRideStatus = '1';
            $shiftCharge = $chargeableRate * $hours;
        }
        return [$shift, $shiftCharge, $priceOverRideStatus];
    }
}
