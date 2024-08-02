<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\Client;
use App\Models\Clientcenter;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Finishshift;
use App\Models\OperactionExp;
use App\Models\Shift;
use App\Models\States;
use App\Models\Tollexpense;
use App\Models\Type;
use App\Models\Vehical;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $driver = $request->input('driverResponsible',null);
        $rego = $request->input('vehicleRego',null);
        for ($i = 1; $i <= 12; $i++) {
            $adminChargeQuery = Shift::whereYear('shiftStartDate', $getYear)->whereMonth('shiftStartDate', $i)->where('finishStatus', '=', '5');
            $driverPayQuery = Shift::whereYear('shiftStartDate', $getYear)->whereMonth('shiftStartDate', $i)->where('finishStatus', '=', '5');
            if($driver){
                $adminChargeQuery->where('driverId',$driver);   
                $driverPayQuery->where('driverId',$driver);   
            }
            if($rego){
                $adminChargeQuery->where('rego',$rego);  
                $driverPayQuery->where('rego',$rego);  
            }

            $adminCharge[] = $adminChargeQuery->sum('chageAmount');
            $driverPay[] = $driverPayQuery->sum('payAmount');
        }
        $firstGraphClientCharge = $adminCharge;
        $firstGraphdriverPay3 = $driverPay;

        $totalsum = [];
        for ($i = 1; $i <= 12; $i++) {
            $expenseReportQuery = DB::table('expenses')->whereYear('created_at', $getYear)->whereMonth('created_at', $i);
            $tollexpenseQuery = DB::table('tollexpenses')->whereYear('created_at', $getYear)->whereMonth('created_at', $i);
            $operactionExpQuery = DB::table('operaction_exps')->whereYear('created_at', $getYear)->whereMonth('created_at', $i);

            if($driver){
                $expenseReportQuery->where('person_name',$driver);   
            }
            if($rego){
                $expenseReportQuery->where('rego',$driver);   
                $tollexpenseQuery->where('rego',$driver);   
                $operactionExpQuery->where('rego',$driver);   
            }
            $expenseReport[] = $expenseReportQuery->sum('cost');
            $tollexpense[] = $tollexpenseQuery->sum('trip_cost');
            $operactionExp[] = $operactionExpQuery->sum('cost');
            
        }

        $driverPayAmount = $driverPay;
        $Clientrate = $adminCharge;
        $secondGraphOverAllExpense = [];
        $clientCharge = [];
        $secondClientrate = [];
        for ($i = 0; $i <= 11; $i++) {
            $secondGraphOverAllExpense[$i] = (int) ($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i] + $driverPayAmount[$i]);
            $clientCharge[$i] = (int) ($Clientrate[$i]);
            $secondClientrate[$i] = (int) ($clientCharge[$i]) - ($secondGraphOverAllExpense[$i]);  // Profit and loss
            $totalsum[$i] = (int) ($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i] + $driverPayAmount[$i] - $Clientrate[$i]);
        }

        // dd($driver,$expenseReport);

        

        $row = Shift::selectRaw('driverId')->groupBy('driverId')->get();
        $driverId[] = '';
        foreach ($row as $allDriver) {
            $driverId[] = $allDriver->driverId;
            $allDriver->pendingCount = Shift::where('driverId', $allDriver->driverId)->where('finishStatus', '0')->count();
            $allDriver->doneCount = Shift::where('driverId', $allDriver->driverId)->where('finishStatus', '1')->count();
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
        $clientNameQuery = Client::with('getState')->leftJoin('shifts', 'clients.id', '=', 'shifts.client')
        ->select('clients.*', DB::raw('SUM(shifts.chageAmount) as total_chageAmount'),DB::raw('SUM(shifts.payAmount) as total_payAmount'));
        if($driver){
            $clientNameQuery->where('shifts.driverId',$driver);   
        }
        if($rego){
            $clientNameQuery->where('shifts.rego',$rego);   
        }

        $clientName = $clientNameQuery->groupBy('clients.id')->limit(3)->get();
        $name = [];
        $adminCharge = [];
        $driverPay = [];
        // dd($clientName);
        foreach ($clientName as $allClient) {
            $name[] = $allClient->name.' ('.$allClient->getState->name.')';
            $adminCharge[] = $allClient->total_chageAmount;
            $driverPay[] = $allClient->total_payAmount;
        }
        $clientName1 = $name;
        $adminCharge2 = $adminCharge;
        $driverPay3 = $driverPay;
        // End Client Profit And Loss.................................. 2
        // Box Section
        $expenseReport = Expense::sum('cost');
        $tollexpense = Tollexpense::sum('trip_cost');
        $operactionExp = OperactionExp::sum('cost');
        // End Box Section
        $data['totalDriver'] = Driver::count();
        $data['totalClient'] = Client::count();
        $data['totalVehicle'] = Vehical::count();
        $data['totalShift'] = Shift::count();
        $data['driverFilter'] = Driver::where('status', '1')->get();
        $data['totalRego'] = Vehical::select('id', 'rego')->get();
        // new design Box count section
        $data['driverPay'] = DB::table('shifts')->where('finishStatus','5')->sum('payAmount');
        $data['clientPay'] = DB::table('shifts')->where('finishStatus','5')->sum('chageAmount');
        $data['tollexpense'] = $tollexpense;
        // end box design section
        $data['check'] = '';
        $yearName = $request->input('getYear');
        $driverResponsible = $request->input('driverResponsible');
        $vehicleRego = $request->input('vehicleRego');
        $data['allRego'] = Vehical::leftJoin('shifts', 'shifts.rego', '=', 'vehicals.id')
        ->select('vehicals.*', DB::raw('SUM(shifts.payAmount) as total_payAmount'), DB::raw('SUM(shifts.chageAmount) as total_chageAmount'))
        ->groupBy('vehicals.id')->orderBy('vehicals.id', 'DESC');
        if ($yearName) {
            $data['allRego'] = $data['allRego']->whereYear('vehicals.created_at', $yearName);
        }
        if ($driverResponsible) {
            $data['allRego'] = $data['allRego']->where('vehicals.driverResponsible', $driverResponsible);
        }
        if ($vehicleRego) {
            $data['allRego'] = $data['allRego']->where('vehicals.id', $vehicleRego);
        }
        $data['allRego'] = $data['allRego']->with(['getShiftRego.getClientNm'])->get();
        // dd($data['allRego']);
        $list = '0';
        $roleId = Auth::guard('adminLogin')->user();
        if ($roleId->role_id !== 1) {
            $driverId = Driver::where('email', $roleId->email)->first()->id;
            $data['monthlyShift'] = Shift::where('driverId', $driverId)->count();
            $data['totalReceivedAmount'] = Shift::where('driverId', $driverId)->where('finishStatus', '=', '5')->sum('payAmount');
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
            $query = $query->where('driverId', $driverId)->whereIn('finishStatus', ['0', '1']);
        }
        $data['shift'] = $query->orderBy('id', 'DESC')->with('getClientName:id,name', 'getDriverName:id,userName', 'getVehicleType:id,name', 'getStateName:id,name', 'getFinishShift')->get();
       
        $data['state'] = DB::table('states')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['clientcenter'] = Clientcenter::select('id', 'name')->get();
        $data['clientbases'] = DB::table('clientbases')->select('id', 'base')->get();
        // dd($adminCharge2,$driverPay3,$clientName1);
        //   return $userData;
        return view('admin.dashboard.home', $data, compact('secondGraphOverAllExpense', 'clientCharge', 'secondClientrate', 'firstGraphClientCharge', 'firstGraphdriverPay3', 'yearName', 'driverResponsible', 'vehicleRego', 'expenseReport', 'Clientrate', 'tollexpense', 'operactionExp', 'totalsum', 'row', 'list', 'clientName1', 'adminCharge2', 'driverPay3'));
    }

    public function shiftStart(Request $request)
    {
        $shiftStart = $request->input('shiftId');
        $shift = Shift::whereId($shiftStart)->update(['finishStatus' => '1', 'shiftStartDate' => date('Y-m-d H:i:s')]);
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
        if (request()->isMethod('post')) {
           
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
            $start_date = Carbon::parse($startDate)->format('Y-m-d H:i:s');
            $end_date = Carbon::parse($endDate)->format('Y-m-d H:i:s');
            $startDate = strtotime($start_date);
            $endDate = strtotime($end_date);
            $query = Shift::where('id', $shiftId);
                $shiftData = Shift::whereId($shiftId)->first();
                $getClientID = $shiftData->client;
                $data['shiftView'] = $query->orderBy('id', 'DESC')->with([
                    'getPersonRates', 'getDriverName', 'getStateName:id,name', 'getClientName:id,name,shortName', 'getCostCenter:id,name', 'getVehicleType:id,name', 'getFinishShifts', 'getShiftMonetizeInformation', 'getClientVehicleRates',
                    'getClientCharge' => function ($query) use ($getClientID) {
                        $query->where('clientId', $getClientID);
                    },
                ])->first();
                //    dd( $data['shiftView']);
                $data['allstate'] = States::where('status', '1')->get();
                $data['costCenter'] = DB::table('clientcenters')->select('id', 'name')->where(['status' => '1', 'clientId' => $getClientID])->get();
                $data['client'] = Client::where(['status' => '1'])->get();
                $data['types'] = Type::where(['status' => '1'])->get();
            $clientRates = DB::table('clientrates')->where(['clientId'=>$data['shiftView']->client,'type'=>$data['shiftView']->vehicleType])->first();
            $extra_rate_per_hour = $request->input('driverId') ? Driver::whereId($request->input('driverId'))->first()->extra_rate_per_hour : Driver::whereId($data['shiftView']->driverId)->first()->extra_rate_per_hour;

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
            $priceCompare = DB::table('personrates')->where('type', $data['shiftView']->vehicleType)->where('personId', $data['shiftView']->driverId)->first();
            
            
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
            $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
            Shift::where('id', $shiftId)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus,'shiftStartDate'=>date('Y-m-d H:i:s',strtotime($request->startDate))]);
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

            $image = $request->file('addPhoto');
            $dateFolder = 'driver/parcel/finishParcel/';
            $imageupload = ImageController::upload($image, $dateFolder);

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
            $finishShift->startDate = date('Y-m-d',strtotime($request->startDate));
            $finishShift->endDate = date('Y-m-d',strtotime($request->endDate));
            $finishShift->startTime =date('H:i:00',strtotime($request->startDate));
            $finishShift->endTime = date('H:i:00',strtotime($request->endDate));
            $finishShift->submitted_at = date('Y-m-d H:i:s');
            $finishShift->parcelsTaken = $parcelsTaken;
            $finishShift->parcelsDelivered = $parcelDelivered;
            $finishShift->addPhoto = $imageupload;
            $finishShift->save();

            
                $existingFinishshiftId = $shiftId;
                if ($existingFinishshiftId) {
                    DB::table('shiftMonetizeInformation')->insert(['shiftId'=>$shiftId,'amountPayablePerService'=>$totalPayShiftAmount,'totalPayable'=>$totalPayShiftAmount,'amountChargeablePerService'=>$totalChargeDay,'totalChargeable'=>$totalChargeDay]);
                } 

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
