<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Alldropdowns;
use App\Models\Clientbase;
use App\Models\rego;
use App\Models\Type;
use App\Models\States;
use App\Models\Parcels;
use App\Models\Client;
use App\Models\Clientcenter;
use App\Models\Missedshift;
use App\Models\Clientrate;
use App\Models\Vehical;

use App\Models\Finishshift;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;
use Hash;
use DateTime;



class ShiftController extends Controller
{
    public $successStatus = 200;
    public $notfound = 404;
    public $unauthorisedStatus = 400;
    public $internalServererror = 500;


     public function __construct(Request $request)
    {
         $this->driverId  = auth('driver')->user()->id??'';
    }


    public function addShift(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "state"          => "required|integer",
            "client"         => "required|integer",
            "costCentre"     => "required|integer",
            "base"           => "required",
            "vehicleType"    => "required|integer",
        //    "rego"           => "required",
            "odometer"       => "required",
            "parcelsToken"   => "required",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

        if($request->input('newRego'))
        {
           $vehicle = new Vehical();
           $vehicle->vehicalType =$request->input('vehicleType');
           $vehicle->rego =$request->input('newRego');
           $vehicle->odometer =$request->input('odometer');
           $vehicle->driverResponsible =$this->driverId;
           $vehicle->save();
           $rego=$vehicle->id;
        }
        else{
            $rego=$request->rego;
        }


        $shify               = new Shift();
        $shify->shiftRandId	= rand('9999','0000');
        $shify->driverId	= $this->driverId;
        $shify->state	   = $request->state;
        $shify->client	   = $request->client;
        $shify->costCenter = $request->costCentre;
        $shify->base	   = $request->base;
        $shify->vehicleType	= $request->vehicleType;
        $shify->rego	    = $rego;
        $shify->odometer	= $request->odometer;
        $shify->scanner_id  = $request->scanner_id;
        $shify->parcelsToken = $request->parcelsToken;
        $shify->save();

        if($shify)
        {
        return response()->json([
            "status" => $this->successStatus,
            "message" => "Driver Shift Added Successfully",
        ]);
        }
    }

    public function trackLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "shiftid"     => "required|integer",
            "latitude"    => "required",
            "longitude"   => "required",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

        $data = [
                'driver_id'  =>  $this->driverId,
                'shiftid'    => $request->input('shiftid'),
                'latitude'   => $request->input('latitude'),
                'longitude'  => $request->input('longitude'),
             ];

        $inserData= DB::table('track_location')->insert($data);
        if($inserData)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Success",
            ]);
        }
        else{
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Location not added ",
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







    function calculateShiftHoursWithMinutes($startDate, $endDate)
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

        return  [
            'dayHours' => floor($dayMinutes / 60),
            'dayMinutes' => $dayMinutes % 60 < 10 ? "0" . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60 , 2),
             'dayTotal' => number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60 , 2), 2),

            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => $nightMinutes % 60 < 10 ? "0" . ($nightMinutes % 60) : $nightMinutes % 60,
            'nightMinutesNew' => round(floor($nightMinutes % 60) / 60 , 2),
            'nightTotal' => number_format(floor($nightMinutes / 60) + round(floor($nightMinutes % 60) / 60 , 2), 2),


            'saturdayHours' => floor($saturdayMinutes / 60),
            'saturdaMinutes' => $saturdayMinutes % 60,
            'saturdayMinutesNew' => round(floor($saturdayMinutes % 60) / 60,2),
            'totalSaturdayHours' => number_format(floor($saturdayMinutes / 60) + round(floor($saturdayMinutes % 60) / 60 , 2), 2),


            'sundayHours' => floor($sundayMinutes / 60),
            'sundayMinutes' => $sundayMinutes % 60,
             'sundayMinutesNew' => round(floor($sundayMinutes % 60) / 60 , 2),
             'totalSundayHours' => number_format(floor($sundayMinutes / 60) + round(floor($sundayMinutes % 60) / 60 , 2), 2),

        ];
    }




    public function updateShiftTiming(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "shiftid"       => "required|integer",
            "startDate" => "required|date_format:Y-m-d H:i",
            "finishDate"   => "required|date_format:Y-m-d H:i",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }


            $startDate = $request->startDate;
            $endDate = $request->finishDate;

            $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
            $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');


            $startDate    = strtotime($start_date);
            $endDate      = strtotime($end_date);

            $result       = $this->calculateShiftHoursWithMinutes($startDate, $endDate);

            $dayHr       =   $result['dayTotal'];
            $nightHr     =   $result['nightTotal'];
            $saturdayHrs =   $result['totalSaturdayHours'];
            $sundayHrs   =   $result['totalSundayHours'];
            $weekend     =   $saturdayHrs + $sundayHrs;

            $dayShift           = '0';
            $nightShift         = '0';
            $sundayHr           = '0';
            $saturdayHr         = '0';
            $dayShiftCharge     =  '0';
            $nightShiftCharge    = '0';
            $saturdayShiftCharge = '0';
            $sundayShiftCharge   = '0';
            $priceOverRideStatus = '0';

         $id=$request->input('shiftid');
         $getClientID = Shift::whereId($id)->first()->client??'';
         if($getClientID)
         {

        $query = Shift::where('id', $id);
        $data['shiftView'] = $query->orderBy('id', 'DESC')->with([
            'getClientCharge' => function ($query) use ($getClientID) {
                $query->where('clientId', $getClientID);
            }
        ])->first();

          $priceCompare = DB::table('personrates')
                                    ->where('type', $data['shiftView']->vehicleType)
                                    ->where('personId', $data['shiftView']->driverId)
                                    ->first();


            if (!empty($dayHr) || !empty($nightHr)   || !empty($saturdayHrs)   || !empty($sundayHrs)) {

                if (!empty($dayHr)) {

                    if (empty($priceCompare)) {
                        $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay  * $dayHr;
                        $priceOverRideStatus = '0';
                        $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays  * $dayHr ?? 0;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay * $dayHr ?? 0;
                            $priceOverRideStatus = '0';
                            $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                        } else {
                            $priceComparehourlyRatePayableDays = !empty($priceCompare->hourlyRatePayableDays) ? $priceCompare->hourlyRatePayableDays : 1;
                            $dayShift = $priceComparehourlyRatePayableDays * $dayHr;
                            $priceOverRideStatus = '1';
                            $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0;
                        }
                    }
                }


                if (!empty($nightHr)) {
                    if (empty($priceCompare)) {
                        $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight   * $nightHr ;
                        $priceOverRideStatus = '0';
                        $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight  * $nightHr;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight) {
                            $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr;
                            $priceOverRideStatus = '0';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        } else {
                            $priceComparehourlyRatePayableNight = !empty($priceCompare->hourlyRatePayableNight) ? $priceCompare->hourlyRatePayableNight : '1';
                            $nightShift = $priceComparehourlyRatePayableNight * $nightHr;
                            $priceOverRideStatus = '1';
                            $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight * $nightHr;
                        }
                    }
                }


                if (!empty($saturdayHrs)) {

                    if (empty($priceCompare)) {
                        $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday   * $saturdayHrs ;
                        $priceOverRideStatus = '0';
                        $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday ?? 0 * $saturdayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs;
                            $priceOverRideStatus = '0';
                            $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                        } else {
                            $saturdayHr = $priceCompare->hourlyRatePayableSaturday * $saturdayHrs;
                            $priceOverRideStatus = '1';
                            $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday * $saturdayHrs;
                        }
                    }
                }

                $floatValue = $sundayHrs;
                $intValue = (int)$floatValue;
                if (!empty($intValue)) {
                    if (empty($priceCompare)) {
                        $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday  * $sundayHrs ;
                        $priceOverRideStatus = '0';
                        $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay) {
                            $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday  * $sundayHrs ;
                            $priceOverRideStatus = '0';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        } else {
                            $sundayHr = $priceCompare->hourlyRatepayableSunday * $sundayHrs;
                            $priceOverRideStatus = '1';
                            $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                        }
                    }
                }
            }


            $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;

            Shift::where('id', $id)->update(['payAmount' => $totalPayShiftAmount, 'priceOverRideStatus' => $priceOverRideStatus]);

            $totalChargeDay   = $dayShiftCharge + $nightShiftCharge + $saturdayShiftCharge + $sundayShiftCharge;

            Shift::where('id', $id)->update(['chageAmount' => $totalChargeDay]);
            $totalHr = $data = $dayHr + $nightHr;

            $driverPay = Client::where('id', $getClientID)->first();
            $driverIncome = $totalPayShiftAmount ?? '0' + $driverPay->driverPay ?? '0';
            Client::where('id', $getClientID)->update(['driverPay' => $driverIncome]);


            $adminCharge = Client::where('id', $getClientID)->first();
            $chargeAdmin = $totalChargeDay ?? '' + $adminCharge->adminCharge ?? '0';
            Client::where('id', $getClientID)->update(['adminCharge' => $chargeAdmin]);

            $existingFinishshiftId = $id;
            if ($existingFinishshiftId)
            {
                $Parcel = Finishshift::where('shiftId', $existingFinishshiftId)->first();
                if ($Parcel)
                {
                    $Parcel->dayHours = $dayHr;
                    $Parcel->nightHours = $nightHr;
                    $Parcel->totalHours = $totalHr;
                    $Parcel->saturdayHours = $saturdayHrs;
                    $Parcel->sundayHours = $sundayHrs;
                    $Parcel->weekendHours = $weekend;
                    $Parcel->startDate = Carbon::parse($startDate)->format('Y-m-d');
                    $Parcel->endDate = Carbon::parse($endDate)->format('Y-m-d');
                    // $Parcel->startDate = $start_date;
                    // $Parcel->endDate = $end_date;
                    $Parcel->startTime = Carbon::parse($startDate)->format('H:i');
                    $Parcel->endTime = Carbon::parse($endDate)->format('H:i');
                    $Parcel->save();
                }
            }
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Shift Time updated Successfully",
            ]);
        }

            else
            {
                return response()->json([
                        "status" => $this->notfound,
                        "message" => "Shift'id is not exist",
                    ]);
            }

    }

    public function missedShift(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "state"          => "required|integer",
            "client"         => "required|integer",
            "costCentre"     => "required|integer",
            "vehicleType"    => "required|integer",
            // "parcelsToken"   => "required",
             "scanner_id"     => "required",
             "odometer_start_reading" => "required",
             "odometer_finish_reading" => "required",
             "start_date" => "required",
             "end_date" => "required",
             "start_time" => "required",
             "end_time" => "required",
             "parcelsToken" => "required",
             "parcel_delivered" => "required",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

        if($request->input('newRego'))
        {
           $vehicle = new Vehical();
           $vehicle->vehicalType =$request->input('vehicleType');
           $vehicle->rego =$request->input('newRego');
           $vehicle->save();
           $rego=$vehicle->id;
        }
        else{
            $rego=$request->rego;
        }

        $shify               = new Shift();
        $shify->shiftRandId  = rand('9999','0000');
        $shify->driverId	 = $this->driverId;
        $shify->state	     = $request->state;
        $shify->client	     = $request->client;
        $shify->costCenter   = $request->costCentre;
        $shify->base	     = $request->base;
        $shify->shiftStartDate = $request->start_date . ' ' . $request->start_time;
        $shify->vehicleType	 = $request->vehicleType;
        $shify->rego	     = $rego;
        $shify->odometer	 = $request->odometer_start_reading;
        $shify->scanner_id   = $request->scanner_id;
        $shify->parcelsToken = $request->parcelsToken;
        $shify->comment = $request->comment;
        $shify->finishStatus  = '2';
        $shify->save();

       $getClientID=Shift::whereId($shify->id)->first()->client;
       $query=Shift::whereId($shify->id);
       $data['shiftView']=$query->orderBy('id','DESC')->with(['getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name','getFinishShifts','getClientVehicleRates','getClientCharge'=> function ($query) use ($getClientID) {$query->where('clientId',$getClientID);}])->first();
       $priceCompare=DB::table('personrates')->where('type',$data['shiftView']->vehicleType)->where('personId',$data['shiftView']->driverId)->first();

    //    $dayHr      = $request->dayHours?? 0;
    //    $nightHr    = $request->nightHours?? 0;
    //    $saturdayHrs = $request->saturdayHours?? 0;
    //    $sundayHrs   = $request->sundayHours?? 0;
    //    $weekendHours = $saturdayHrs + $sundayHrs;
    //    $totalHours = $dayHr + $nightHr;

    $startDate = $request->start_date.' '.$request->start_time;
    $endDate = $request->end_date.' '.$request->input('end_time');
    $start_date = Carbon::parse($startDate)->format('Y-m-d H:i');
    $end_date = Carbon::parse($endDate)->format('Y-m-d H:i');
    $startDate    = strtotime($start_date);
    $endDate      = strtotime($end_date);
    $dayStartTime = Carbon::parse($start_date);
    $nightEndTime = Carbon::parse($end_date);


    $result = $this->calculateShiftHoursWithMinutes($startDate, $endDate);



    // $dayHr = $result['dayHours'] . '.' . $result['dayMinutes'];
    // $nightHr = $result['nightHours'] . '.' . $result['nightMinutes'];
    // $saturdayHrs = $result['saturdayHours'] . '.' . $result['saturdayMinutes'];
    // $sundayHrs = $result['sundayHours'] . '.' . $result['sundayMinutes'];
    // $weekendHours = $saturdayHrs + $sundayHrs;

    $dayHr        =   $result['dayTotal'];
    $nightHr      =   $result['nightTotal'];
    $saturdayHrs  =   $result['totalSaturdayHours'];
    $sundayHrs    =   $result['totalSundayHours'];
    $weekendHours =   $saturdayHrs + $sundayHrs;


    $dayShift = $nightShift = $sundayHr = $saturdayHr = $dayShiftCharge = $nightShiftCharge = $saturdayShiftCharge = $sundayShiftCharge = $priceOverRideStatus = '0';

     if(!empty($dayHr) || !empty($nightHr)   || !empty($saturdayHrs)   || !empty($sundayHrs))
     {

       if (!empty($dayHr))
       {
            if(empty($priceCompare))
            {
                 $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay  * $dayHr;
                 $priceOverRideStatus = '0';
                 $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays * $dayHr ?? 0 ;
           }
           else
           {
               if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay)
               {
                   $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay   * $dayHr ?? 0 ;
                   $priceOverRideStatus = '0';
                   $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays  * $dayHr ?? 0 ;
               }
               else {
                   $dayShift = $priceCompare->hourlyRatePayableDayss  * $dayHr;
                   $priceOverRideStatus = '1';
                   $dayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableDays  * $dayHr ?? 0;
                 }
           }
       }


       if (!empty($nightHr)) {
           if(empty($priceCompare))
            {
               $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight  * $nightHr ?? 0;
               $priceOverRideStatus = '0';
               $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight  * $nightHr;
           }
           else
           {
               if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableNight)
               {
                   $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight   * $nightHr ?? 0;
                   $priceOverRideStatus = '0';
                   $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight  * $nightHr;
               }
               else {
                   $nightShift = $priceCompare->hourlyRatePayableNight * $nightHr;
                   $priceOverRideStatus = '1';
                   $nightShiftCharge = $data['shiftView']->getClientCharge->ourlyRateChargeableNight  * $nightHr;

                 }
           }
       }


       if (!empty($saturdayHrs)) {

           if(empty($priceCompare))
           {
               $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday * $saturdayHrs ?? 0;
               $priceOverRideStatus = '0';
               $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday  * $saturdayHrs;
          }
          else
          {
              if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay)
              {
               $saturdayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSaturday   * $saturdayHrs ?? 0;
               $priceOverRideStatus = '0';
               $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday  * $saturdayHrs;
              }
              else {
               $saturdayHr = $priceCompare->hourlyRatePayableSaturday * $saturdayHrs;
               $priceOverRideStatus = '1';
               $saturdayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday  * $saturdayHrs;
                }
          }

       }


       if (!empty($sundayHrs)) {
           if(empty($priceCompare))
           {
               $sundayHr = $data['shiftView']->getClientCharge->hourlyRatePayableSunday   * $sundayHrs ?? 0;
               $priceOverRideStatus = '0';
               $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday  * $sundayHrs;
          }
          else
          {
              if ($priceCompare->hourlyRatePayableDays < $data['shiftView']->getClientCharge->hourlyRatePayableDay)
              {
               $sundayHr = $data['shiftView']->getClientCharge->hourlyRatepayableSunday   * $sundayHrs ?? 0;
               $priceOverRideStatus = '0';
               $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday ?? 0 * $sundayHrs;
              }
              else {
               $sundayHr = $priceCompare->hourlyRatepayableSunday  * $sundayHrs ;
               $priceOverRideStatus = '1';
               $sundayShiftCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday * $sundayHrs;
                }
          }
       }

           $totalPayShiftAmount = $dayShift + $nightShift + $saturdayHr + $sundayHr;
           $totalChargeDay   = $dayShiftCharge+$nightShiftCharge+$saturdayShiftCharge+$sundayShiftCharge;
           Shift::where('id',$shify->id)->update(['payAmount'=>$totalPayShiftAmount,'priceOverRideStatus'=>$priceOverRideStatus]);
           DB::table('clientcharge')->insert(['shiftId'=>$shify->id,'amount' => $totalPayShiftAmount,'status'=>'0']);  // O is pay to Driver
           DB::table('clientcharge')->insert(['shiftId'=>$shify->id,'amount' => $totalChargeDay,'status'=>'1']); // 1 is charge to admin
           // is Driver Payable

     }

       // Client charage Amount
           Shift::where('id',$shify->id)->update(['chageAmount'=>$totalChargeDay]);
           $totalHr = $data=$dayHr+$nightHr;
        // End client Charge Amount

           $driverPay= Client::where('id',$getClientID)->first();
           $driverIncome=$totalPayShiftAmount??'0'+$driverPay->driverPay??'0';
           Client::where('id',$getClientID)->update(['driverPay'=>$driverIncome]);

           $adminCharge= Client::where('id',$getClientID)->first();
           $chargeAdmin=$totalChargeDay??''+$adminCharge->adminCharge??'0';
           Client::where('id',$getClientID)->update(['adminCharge'=>$chargeAdmin]);

            shift::whereId($shify->id)->update(['finishStatus'=>'2']);


                //     $start_date = $request->start_date;
                //     $end_date = $request->end_date;

                //     $data['startDate']=date('d-m-Y', strtotime($start_date));
                //     $data['endDate']=date('d-m-Y', strtotime($end_date));

                //      $data['weekend1']  = Carbon::parse($data['startDate'])->dayName;
                //      $data['weekend2']  = Carbon::parse($data['endDate'])->dayName;

                //    $weekend1=$data['weekend1'];
                //    $weekend2=$data['weekend2'];
                //    $data['dayHours1'] = $request->dayHours;
                //    $data['dayHours']  = ($data['shiftView']->getClientCharge->hourlyRatePayableDay??'0')*$data['dayHours1'];

                //    $data['nightHour1']=$request->nightHours;
                //    $data['nightHours']=($data['shiftView']->getClientCharge->hourlyRatePayableNight??'0')*$data['nightHour1'];
                //    $clientId = $getClientID;




            //        if ($weekend1=="Saturday" || $weekend2=='Sunday')
            //        {
            //             if($priceCompare->hourlyRatePayableSaturday??'0' < $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday??'0')
            //             {
            //                 $dayShift = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday*$data['dayHours1'];
            //                 $priceOverRideStatus='0';
            //             }
            //             else
            //             {
            //                 $dayShift = $priceCompare->hourlyRatePayableDays*$data['dayHours1'];
            //                 $priceOverRideStatus='1';
            //             }

            //             if($priceCompare->hourlyRatepayableSunday??'0' < $data['shiftView']->getClientCharge->hourlyRateChargeableSunday??'0')
            //             {
            //                 $nightShift = $data['shiftView']->getClientCharge->hourlyRateChargeableSunday*$data['nightHour1'];
            //                 $priceOverRideStatus='0';
            //             }
            //             else
            //             {
            //                 $nightShift = $priceCompare->hourlyRatePayableNight*$data['nightHour1'];
            //                 $priceOverRideStatus='1';
            //             }

            //             $totalPayShiftAmount=$dayShift+$nightShift;
            //             Shift::where('id',$shify->id)->update(['payAmount'=>$totalPayShiftAmount]);

            //            // Client Charge Amount
            //             $saturdayCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday*$data['dayHours1'];
            //             $sundayCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday*$data['nightHour1'];
            //             $totalweekendChargeDay=$saturdayCharge+$sundayCharge;
            //             Shift::where('id',$shify->id)->update(['chageAmount'=>$totalweekendChargeDay]);
            //            // End Client Charge Amount

            //            $driverPay= Client::where('id',$clientId)->first();
            //            $driverIncome=$totalPayShiftAmount+$driverPay->driverPay??'0';
            //            Client::where('id',$clientId)->update(['driverPay'=>$driverIncome]);

            //            $adminCharge= Client::where('id',$clientId)->first();
            //            $chargeAdmin=$totalweekendChargeDay+$adminCharge->adminCharge??'0';
            //            Client::where('id',$clientId)->update(['adminCharge'=>$chargeAdmin]);
            //        }
            //        else
            //        {
            //             if($priceCompare->hourlyRatePayableDays??'0' < $data['shiftView']->getClientCharge->hourlyRatePayableDay??'0')
            //             {
            //                 $dayShift = $priceCompare->hourlyRatePayableDays*$data['dayHours1'];
            //                 $priceOverRideStatus='1';
            //             }
            //             else
            //             {
            //                 $dayShift = $data['shiftView']->getClientCharge->hourlyRatePayableDay*$data['dayHours1'];
            //                 $priceOverRideStatus='0';
            //             }


            //             if($priceCompare->hourlyRatePayableNight??'0' < $data['shiftView']->getClientCharge->hourlyRatePayableNight??'0')
            //             {
            //                 $nightShift = $priceCompare->hourlyRatePayableNight*$data['nightHour1'];
            //                 $priceOverRideStatus='1';
            //             }
            //             else
            //             {
            //                 $nightShift = $data['shiftView']->getClientCharge->hourlyRatePayableNight*$data['nightHour1'];
            //                 $priceOverRideStatus='0';

            //             }

            //             $totalPayShiftAmount=$dayShift+$nightShift;

            //             Shift::where('id',$shify->id)->update(['payAmount'=>$totalPayShiftAmount]);

            //             // Client Charge Amount
            //             $saturdayCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday*$data['dayHours1'];
            //             $sundayCharge = $data['shiftView']->getClientCharge->hourlyRateChargeableSaturday*$data['nightHour1'];
            //             $totalweekendChargeDay=$saturdayCharge+$sundayCharge;
            //             Shift::where('id',$shify->id)->update(['chageAmount'=>$totalweekendChargeDay]);
            //             // End Client Charge Amount

            //             $driverPay= Client::where('id',$clientId)->first();
            //             $driverIncome=$totalPayShiftAmount??'0'+$driverPay->driverPay??'0';
            //             Client::where('id',$clientId)->update(['driverPay'=>$driverIncome]);

            //             $adminCharge= Client::where('id',$clientId)->first();
            //             $chargeAdmin=$totalweekendChargeDay??'0'+$adminCharge->adminCharge??'0';
            //             Client::where('id',$clientId)->update(['adminCharge'=>$chargeAdmin]);

            //         }



                $files = $request->file('missedImage');
                $destinationPath = 'assets/driver/parcel/finishParcel';
                $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name);
                $items = $file_name;


                   $Parcel                        = new Finishshift();
                   $Parcel->driverId  	          = $this->driverId;
                   $Parcel->shiftId	              = $shify->id;
                   $Parcel->odometerStartReading  = $request->odometer_start_reading;
                   $Parcel->odometerEndReading	  = $request->odometer_finish_reading;

                   $Parcel->dayHours	          = $dayHr;
                   $Parcel->nightHours	          = $nightHr;
                   $Parcel->saturdayHours		  = $saturdayHrs;
                   $Parcel->sundayHours		      = $sundayHrs;
                   $Parcel->weekendHours	      = $weekendHours ?? 0;
                   $Parcel->totalHours	          = $totalHr ?? 0;
                   $Parcel->startDate	          = $request->start_date;
                   $Parcel->endDate	              = $request->end_date;
                   $Parcel->startTime	          = $dayStartTime->format('H:i');
                   $Parcel->endTime	              = $nightEndTime->format('H:i');
                   $Parcel->parcelsTaken	      = $request->parcelsTaken;
                   $Parcel->parcelsDelivered	  = $request->parcel_delivered;
                    $Parcel->addPhoto              = $items;
                   $Parcel->save();

                   if($Parcel)
                   {
                           return response()->json([
                               "status" => $this->successStatus,
                               "message" => "Missed Shift Added Successfully",
                           ]);
                   }

    }

    public function viewAllMissShift(Request $request)
    {


    $driverId  = auth('driver')->user()->id;
    $shift=Missedshift::where('driverId',$driverId)->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime','getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name')->get();

        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,

                "message" => "Success",
                "data" =>$shift
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }



    public function addLocation(Request $request)
    {

        $validator = Validator::make($request->all(), [
                            "shiftId" =>"required",
                            "latitude"=> "required",
                             "longitude"=> "required",
                             "address" =>"required",
                             "type"   =>'required',
                        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

         $id=$request->input('shiftId');
         $type=$request->input('type');

         if($type=='0')
         {
            $latitude=$request->input('latitude');
            $longitude=$request->input('longitude');
            $address =$request->input('address');
            $addLocation=Shift::whereId($id)->update(['startlatitude' =>$latitude, 'startlongitude' =>$longitude,"startaddress"=>$address]);
         }

         if($type=='1')
         {
            $latitude=$request->input('latitude');
            $longitude=$request->input('longitude');
            $address =$request->input('address');
            $addLocation=Shift::whereId($id)->update(['endlatitude' =>$latitude, 'endlongitude' =>$longitude,"endaddress"=>$address]);
         }

         if($addLocation)
         {
         return response()->json([
             "status" => $this->successStatus,
             "message" => "Location Added Successfully",
         ]);
         }
    }


    public function shiftDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "shift_id"          => "required|integer",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

    $driverId  = auth('driver')->user()->id;

    $shift=Shift::select('id','rego','odometer','base','payAmount','parcelsToken','client','costCenter','finishStatus','optShift','state','created_at as createdDate','shiftStartDate','vehicleType','payAmount','startlatitude','startlongitude','endlatitude','endlongitude','startaddress','endaddress','scanner_id','created_at','updated_at')->whereId($request->shift_id)->where('driverId',$driverId)->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime,odometerStartReading,odometerEndReading,parcelsDelivered','getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name')->first();
   // MUje ye check karna gai after  add MonetizeInformation  data shift main add karna hai
    // if (isset($shift->getShiftMonetizeInformation)) {
    //     $shift->payAmount = ($shift->getShiftMonetizeInformation->totalPayable ?? 0) + ($shift->payAmount ?? 0);
    // } else {
    //     // Handle the case where getShiftMonetizeInformation is null
    //     // You may want to set a default value or handle it in some way
    //     $shift->payAmount = $shift->payAmount ?? 0;
    // }


    $shift->ReportDetail=Finishshift::select('dayHours','nightHours','weekendHours','odometerStartReading','odometerEndReading')->where('shiftid',$request->shift_id??'')->first()??'0';
    $shift->ClientBase=Clientbase::select('id','base')->where('id',$shift->base)->first()->base??'';
    $shift->ClientRego=Vehical::select('id','rego')->where('status','1')->where('id',$shift->rego)->first()->rego??'';

    if($shift->ReportDetail=='0')
    {
        $shift->ReportDetail=null;
    }

        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Success",
                "data" =>$shift
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }

    public function shiftStart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "shift_id"          => "required|integer",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

     $driverId  = auth('driver')->user()->id;
     $shift=Shift::whereId($request->shift_id)->where('driverId',$driverId)->update(['finishStatus'=>'1','shiftStartDate'=>date("Y-m-d H:i:s")]);

        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Success",
                "note" =>'Shift Start Successfully'
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "Shift not found",
            ]);
        }
    }

    public function showShift(Request $request)
    {
        $driverId  = auth('driver')->user()->id;
        $query=Shift::select('id','shiftRandId','rego','odometer','parcelsToken','client','costCenter','finishStatus','state','vehicleType','created_at','updated_at');
        $state       = $request->input('state');
        $clientId    =  $request->input('clientId');
        $status      = $request->input('status');
        $startDate   = $request->input('startDate');
        $endDate     = $request->input('endDate');

        if($state)
        {
        $query=$query->Where('state',$state);
        }

        if($clientId)
        {
        $query=$query->Where('client',$clientId);
        }

        if($status)
        {
        $query=$query->Where('finishStatus',$status);
        }
        if($status=='0')
        {
        $query=$query->Where('finishStatus',$status);
        }

        if($startDate)
        {
            $query = $query->where('created_at', '>=',$startDate);
        }

        if($endDate)
        {
            $query->where('finishDate', '<=',$endDate);
        }


        $shift=$query->orderBy('id','DESC')->where('driverId',$driverId)->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime','getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name')->withCount('getParcel')->get();
        $countShift= $shift->count();
            if(!($countShift)==0)
            {
                return response()->json([
                    "status" => $this->successStatus,
                    "countShift" =>$countShift,
                    "message" => "Success",
                    "data" =>$shift
                ]);
            }
            else{
                return response()->json([
                    "status" => $this->notfound,
                    "countShift" =>$countShift,
                    "message" => "not found",
                ]);

            }
    }


    public function homePageShift(Request $request)
    {
        $driverId  = auth('driver')->user()->id;
        $query=Shift::select('id','shiftRandId','rego','odometer','parcelsToken','client','costCenter','finishStatus','state','vehicleType','created_at','updated_at');
        $state       = $request->input('state');
        $clientId    =  $request->input('clientId');
        $status      = $request->input('status');
        $startDate   = $request->input('startDate');
        $endDate     = $request->input('endDate');

        if($state)
        {
        $query=$query->Where('state',$state);
        }

        if($clientId)
        {
        $query=$query->Where('client',$clientId);
        }

        if($status)
        {
        $query=$query->Where('status',$status);
        }

        if($startDate)
        {
            $query = $query->where('created_at', '>=',$startDate);
        }

        if($endDate)
        {
            $query->where('created_at', '<=',$endDate);
        }


        $shift=$query->orderBy('id','DESC')->where('driverId',$driverId)->whereIn('finishStatus',[0,1,2])->with('getFinishShifts:shiftId,startDate,endDate,startTime,endtime','getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name')->withCount('getParcel')->get();

        $countShift= $shift->count();
            if(!($countShift)==0)
            {
                return response()->json([
                    "status" => $this->successStatus,
                    "countShift" =>$countShift,
                    "message" => "Success",
                    "data" =>$shift
                ]);
            }
            else{
                return response()->json([
                    "status" => $this->notfound,
                    "countShift" =>$countShift,
                    "message" => "not found",
                ]);

            }
    }




    public function deleteShift(Request $request)
    {
        $driverId  = auth('driver')->user()->id;

        $validator = Validator::make($request->all(), [
            "shift_id"          => "required|integer",
        ]);

        if ($validator->fails()) {
            $response["status"] = 400;
            $response["response"] = $validator->messages();
            return $response;
        }

        $shift=Shift::whereId($request->shift_id)->where('driverId',$driverId)->delete();
        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Shift Deleted Successfully",
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }

     public function allDropDown(Request $request)
    {
        $alldropdown=Alldropdowns::get();
        $regoField=Vehical::select('id','rego as name','created_at')->where('status','1')->get();

        $typeField=Type::select('id','name','status')->where('status','1')->get();
        foreach($typeField  as $vehicals)
        {
            $vehicals->regoField=DB::table('vehicals')->select('id','rego')->where('status','1')->where('vehicalType',$vehicals->id)->get();
        }

       if($request->input('clientId'))
       {

       $getCostCenter=Clientcenter::select('id','clientId','name')->where('status','1')->where('clientId',$request->input('clientId'))->get();
       foreach($getCostCenter as $allgetCostCenter)
       {
        $allgetCostCenter->clientBase=Clientbase::select('id','base')->where('clientcentersid',$allgetCostCenter->id)->where('cost_center_name',$allgetCostCenter->name)->where('clientId',$request->input('clientId'))->get();
       }

       $getType=Clientrate::select('id','clientId','type')->with(['getClientType'])->where('clientId',$request->input('clientId'))->get();
       foreach($getType as $vehicals)
       {
        $vehicals->regoField=DB::table('vehicals')->select('id','rego')->where('status','1')->where('vehicalType',$vehicals->id)->get();
       }

       }
       else{
            $getCostCenter=[];
            $getType=[];
       }



        if($alldropdown)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "All Dropdown Field",
                "note" => "typeStatus field 1 is state, 2 is cost center",
                "data"   =>$alldropdown,
                "regoField" =>$regoField,
                "typeField" =>$typeField,
                "getCostCenter" =>$getCostCenter,
                "getType"=>$getType
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }

      public function shiftStatus(Request $request)
    {
        $alldropdown=DB::table('shiftstatus')->get();
        if($alldropdown)
        {
            return response()->json([
                "status" => $this->successStatus,
                "message" => "Shift Status",
                "data"   =>$alldropdown
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }




    public function myShiftDetail(Request $request)
    {
      $driverId  = auth('driver')->user()->id;
      $validator = Validator::make($request->all(), [
        "shift_id"          => "required|integer",
    ]);

    if ($validator->fails()) {
        $response["status"] = 400;
        $response["response"] = $validator->messages();
        return $response;
    }

      $shift=Shift::select('id','rego','odometer','parcelsToken','client','costCenter','finishStatus','state','status','vehicleType','startlatitude','startlongitude','endlatitude','endlongitude','startaddress','endaddress','created_at','updated_at')->whereId($request->shift_id)->where('driverId',$driverId)->with('getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name','getClientRate')->first();

        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,

                "message" => "Success",
                "data" =>$shift
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }

    public function filterMyShift(Request $request)
    {
      $driverId  = auth('driver')->user()->id;

      $query=Shift::select('id','rego','odometer','parcelsToken','client','costCenter','status','state','vehicleType','created_at','updated_at');

      $state       = $request->input('state');
      $clientId    =  $request->input('clientId');
      $status      = $request->input('status');
      $startDate   = $request->input('startDate');
      $endDate     = $request->input('endDate');

      if($state)
      {
      $query=$query->Where('state',$state);
      }

      if($clientId)
      {
      $query=$query->Where('client',$clientId);
      }

      if($status)
      {
      $query=$query->Where('status',$status);
      }

      if($startDate)
      {
        $query = $query->where('created_at', '>=',$startDate);
      }

      if($endDate)
      {
        $query->where('created_at', '<=',$endDate);
      }


      $shift=$query->orderBy('id','DESC')->where('driverId',$driverId)->with('getStateName:id,name','getClientName:id,name,shortName','getCostCenter:id,name','getVehicleType:id,name')->get();
      $countShift= $shift->count();
        if($shift)
        {
            return response()->json([
                "status" => $this->successStatus,
                "countShift" =>$countShift,
                "message" => "Success",
                "data" =>$shift
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }




 public function allStates(Request $request)
    {

      $state=States::where('status','1')->get();
        if($state)
        {
            return response()->json([
                "status" => $this->successStatus,

                "message" => "Success",
                "data" =>$state
            ]);
        }
        else{
            return response()->json([
                "status" => $this->notfound,
                "message" => "not found",
            ]);

        }
    }



}


