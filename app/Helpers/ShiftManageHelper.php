<?php


namespace App\Helpers;

use App\Models\Client;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;

class ShiftManageHelper
{


    public static function calculateShiftAmount($request, $shift, $extra_rate_per_hour,$is_miss=false)
    {


        if (in_array($shift->finishStatus, ['1', '2', '3']) || in_array($request->finishStatus, ['1', '2', '3']) || $is_miss) {

            $clientRates = DB::table('clientrates')->where(['clientId' => $shift->client, 'type' => $shift->vehicleType])->first();
            $finishShifts = DB::table('finishshifts')->where(['shiftId' => $shift->id])->first();

            $startDate = $request->shiftStartDate ? strtotime(date('Y-m-d H:i:s', strtotime($request->shiftStartDate))) : null;
            $endDate = $request->finishDate ? strtotime(date('Y-m-d H:i:s', strtotime($request->finishDate))) : null;

            if ($finishShifts) {
                $startDate = $startDate ?? strtotime(date('Y-m-d H:i:s', strtotime($finishShifts->startDate . ' ' . $finishShifts->startTime)));
                $endDate = $endDate ?? strtotime(date('Y-m-d H:i:s', strtotime($finishShifts->endDate . ' ' . $finishShifts->endTime)));
            }

            $result = self::calculateShiftHoursWithMinutes($startDate, $endDate);

            

            $dayHr = $result['dayTotal'];
            $nightHr = $result['nightTotal'];
            $saturdayHrs = $result['totalSaturdayHours'];
            $sundayHrs = $result['totalSundayHours'];
            $weekendHrs = $saturdayHrs + $sundayHrs;

            $totalHr = $dayHr + $nightHr + $weekendHrs;

            $payable_dayShift = '0';
            $payable_nightShift = '0';
            $payable_sundayHr = '0';
            $payable_saturdayHr = '0';
            $chargeable_dayShift = '0';
            $chargeable_nightShift = '0';
            $chargeable_saturdayShift = '0';
            $chargeable_sundayShift = '0';
            $priceOverRideStatus = '0';

            $priceCompare = DB::table('personrates')->where('type', $shift->vehicleType)->where('personId', $shift->driverId)->first();

            if (!empty($dayHr) || !empty($nightHr) || !empty($saturdayHrs) || !empty($sundayHrs)) {
                if (!empty($dayHr)) {
                    if (empty($priceCompare)) {
                        $payable_dayShift = (($clientRates->hourlyRatePayableDay ?? 0) + $extra_rate_per_hour) * $dayHr;
                        $priceOverRideStatus = '0';
                        $chargeable_dayShift = ($clientRates->hourlyRateChargeableDays ?? 0) * $dayHr ?? 0;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                            $payable_dayShift = (($clientRates->hourlyRatePayableDay ?? 0) + $extra_rate_per_hour) * $dayHr ?? 0;
                            $priceOverRideStatus = '0';
                            $chargeable_dayShift = ($clientRates->hourlyRateChargeableDays ?? 0) * $dayHr ?? 0;
                        } else {
                            $priceComparehourlyRatePayableDays = !empty($priceCompare->hourlyRatePayableDays) ? $priceCompare->hourlyRatePayableDays : 1;
                            $payable_dayShift = $priceComparehourlyRatePayableDays * $dayHr;
                            $priceOverRideStatus = '1';
                            $chargeable_dayShift = ($clientRates->hourlyRateChargeableDays ?? 0) * $dayHr ?? 0;
                        }
                    }
                }
                if (!empty($nightHr)) {
                    if (empty($priceCompare)) {
                        $payable_nightShift = (($clientRates->hourlyRatePayableNight ?? 0) + $extra_rate_per_hour) * $nightHr ?? 0;
                        $priceOverRideStatus = '0';
                        $chargeable_nightShift = ($clientRates->ourlyRateChargeableNight ?? 0) * $nightHr;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableNight) {
                            $payable_nightShift = (($clientRates->hourlyRatePayableNight ?? 0) + $extra_rate_per_hour) * $nightHr ?? 0;
                            $priceOverRideStatus = '0';
                            $chargeable_nightShift = ($clientRates->ourlyRateChargeableNight ?? 0) * $nightHr;
                        } else {
                            $priceComparehourlyRatePayableNight = !empty($priceCompare->hourlyRatePayableNight) ? $priceCompare->hourlyRatePayableNight : '1';
                            $payable_nightShift = ($priceComparehourlyRatePayableNight + $extra_rate_per_hour) * $nightHr;
                            $priceOverRideStatus = '1';
                            $chargeable_nightShift = ($clientRates->ourlyRateChargeableNight ?? 0) * $nightHr;
                        }
                    }
                }
                if (!empty($saturdayHrs)) {
                    if (empty($priceCompare)) {
                        $payable_saturdayHr = (($clientRates->hourlyRatePayableSaturday ?? 0) + $extra_rate_per_hour) * $saturdayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $chargeable_saturdayShift = ($clientRates->hourlyRateChargeableSaturday ?? 0) * $saturdayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                            $payable_saturdayHr = (($clientRates->hourlyRatePayableSaturday ?? 0) + $extra_rate_per_hour) * $saturdayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $chargeable_saturdayShift = ($clientRates->hourlyRateChargeableSaturday ?? 0) * $saturdayHrs;
                        } else {
                            $payable_saturdayHr = ($priceCompare->hourlyRatePayableSaturday + $extra_rate_per_hour) * $saturdayHrs;
                            $priceOverRideStatus = '1';
                            $chargeable_saturdayShift = ($clientRates->hourlyRateChargeableSaturday ?? 0) * $saturdayHrs;
                        }
                    }
                }
                $floatValue = $sundayHrs;
                $intValue = (int) $floatValue;
                if (!empty($intValue)) {
                    if (empty($priceCompare)) {
                        $payable_sundayHr = (($clientRates->hourlyRatePayableSunday ?? 0) + $extra_rate_per_hour) * $sundayHrs ?? 0;
                        $priceOverRideStatus = '0';
                        $chargeable_sundayShift = ($clientRates->hourlyRateChargeableSunday ?? 0) * $sundayHrs;
                    } else {
                        if ($priceCompare->hourlyRatePayableDays < $clientRates->hourlyRatePayableDay) {
                            $payable_sundayHr = (($clientRates->hourlyRatePayableSunday ?? 0) + $extra_rate_per_hour) * $sundayHrs ?? 0;
                            $priceOverRideStatus = '0';
                            $chargeable_sundayShift = ($clientRates->hourlyRateChargeableSunday ?? 0) * $sundayHrs;
                        } else {
                            $payable_sundayHr = ($priceCompare->hourlyRatepayableSunday + $extra_rate_per_hour) * $sundayHrs;
                            $priceOverRideStatus = '1';
                            $chargeable_sundayShift = ($clientRates->hourlyRateChargeableSunday ?? 0) * $sundayHrs;
                        }
                    }
                }

               

                $amount_Payable_Per_Service = (float)($payable_dayShift + $payable_nightShift + $payable_saturdayHr + $payable_sundayHr);
                $amount_Amount_Chargeable_Per_Service = (float)($chargeable_dayShift + $chargeable_nightShift + $chargeable_saturdayShift + $chargeable_sundayShift);

                
                $shiftMonetize = DB::table('shiftMonetizeInformation')->where('shiftId', $shift->id)->first();

                $fuelLevyPayable = (float)$request->input('fuelLevyPayable', $shiftMonetize->fuelLevyPayable ?? 0);
                $extraPayable = (float)$request->input('extraPayable', $shiftMonetize->extraPayable ?? 0);

                $fuelLevyChargeable250 = (float)$request->input('fuelLevyChargeable250', $shiftMonetize->fuelLevyChargeable250 ?? 0);
                $fuelLevyChargeable = (float)$request->input('fuelLevyChargeable', $shiftMonetize->fuelLevyChargeable ?? 0);
                $fuelLevyChargeable400 = (float)$request->input('fuelLevyChargeable400', $shiftMonetize->fuelLevyChargeable400 ?? 0);
                $extraChargeable = (float)$request->input('extraChargeable', $shiftMonetize->extraChargeable ?? 0);

                $totalShiftPayable = $amount_Payable_Per_Service + $fuelLevyPayable + $extraPayable;
                $totalShiftChargeable = $amount_Amount_Chargeable_Per_Service + $fuelLevyChargeable250 + $fuelLevyChargeable + $fuelLevyChargeable400 + $extraChargeable;

                Shift::where('id', $shift->id)->update(['payAmount' => $totalShiftPayable, 'priceOverRideStatus' => $priceOverRideStatus, 'chageAmount' => $totalShiftChargeable]);


                $clientDataPay = Client::where('id', $shift->client)->first();
                $driverIncome = (float)($totalPayShiftAmount ?? 0) + (float)($clientDataPay->driverPay ?? 0);
                $chargeAdmin = (float)($totalChargeDay ?? 0) + (float)($clientDataPay->adminCharge ?? 0);
                Client::where('id', $shift->client)->update(['adminCharge' => $chargeAdmin,'driverPay' => $driverIncome]);


                if ($finishShifts) {
                    $finishShiftsData= [
                        "dayHours" => $dayHr,
                        "nightHours" => $nightHr,
                        "totalHours" => $totalHr,
                        "saturdayHours" => $saturdayHrs,
                        "sundayHours" => $sundayHrs,
                        "weekendHours" => $weekendHrs,
                        "startDate" => date('Y-m-d',$startDate),
                        "endDate" => date('Y-m-d',$endDate),
                        "startTime" => date('H:i:s',$startDate),
                        "endTime" => date('H:i:s',$endDate),
                        "parcelsTaken" => $request->input('parcelsToken',$finishShifts->parcelsTaken),
                        "submitted_at" => $finishShifts->submitted_at ?? date('Y-m-d H:i:s'),
                        "parcelsDelivered" => $request->input('parcelsDelivered',$finishShifts->parcelsDelivered),
                        "odometerStartReading" => $request->input('odometerStartReading',$finishShifts->odometerStartReading),
                        "odometerEndReading" => $request->input('odometerEndReading',$finishShifts->odometerEndReading)
                    ];
                    // dd($shift->id);
                    DB::table('finishshifts')->where(['shiftId'=>$shift->id])->update($finishShiftsData);
                    // dd($finishShiftsData);
                }else {
                    $finishshift_data = [
                        'shiftId'=>$shift->id,
                        'dayHours' => $dayHr,
                        'nightHours' => $nightHr,
                        'totalHours' => $totalHr,
                        'saturdayHours' => $saturdayHrs,
                        'sundayHours' => $sundayHrs,
                        'weekendHours' => $weekendHrs,
                        'startDate' =>date('Y-m-d',$startDate),
                        'endDate' => date('Y-m-d',$endDate),
                        'startTime' => date('H:i:s',$startDate),
                        'endTime' => date('H:i:s',$endDate),
                        'parcelsTaken' => $request->input('parcelsToken'),
                        'parcelsDelivered' => $request->input('parcelsDelivered'),
                        'odometerStartReading' => $request->input('odometerStartReading'),
                        'odometerEndReading' => $request->input('odometerEndReading')
                    ];
                    DB::table('finishshifts')->insert($finishshift_data);
                }

                $shiftMonetizeInformation = 
                [
                    'amountPayablePerService' => $amount_Payable_Per_Service,
                    'fuelLevyPayable' => $fuelLevyPayable,
                    'extraPayable' => $extraPayable,
                    'totalPayable' => $totalShiftPayable,
                    'comments' => $request->input('comments'),
                    'approvedReason' => $request->input('approvedReason'),
                    'amountChargeablePerService' => $amount_Amount_Chargeable_Per_Service,
                    'fuelLevyChargeable250' => $fuelLevyChargeable250,
                    'fuelLevyChargeable' => $fuelLevyChargeable,
                    'fuelLevyChargeable400' => $fuelLevyChargeable400,
                    'extraChargeable' => $extraChargeable,
                    'totalChargeable' => $totalShiftChargeable
                ];

                // dd($shiftMonetizeInformation);


                if ($shiftMonetize) {
                    $shiftMonetizeInformation['shiftId'] = $shift->id;
                    DB::table('shiftMonetizeInformation')->where('shiftId', $shift->id)->update($shiftMonetizeInformation);
                } else {
                    $shiftMonetizeInformation['shiftId'] = $shift->id;
                    DB::table('shiftMonetizeInformation')->insert($shiftMonetizeInformation);
                }
            }
        }
    }


    public static function calculateShiftHoursWithMinutes($startDate, $endDate)
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
            'dayMinutes' => (float)$dayMinutes % 60 < 10 ? '0' . ($dayMinutes % 60) : $dayMinutes % 60,
            'dayMinutesNew' => round(floor($dayMinutes % 60) / 60, 2),
            'dayTotal' => (float)number_format(floor($dayMinutes / 60) + round(floor($dayMinutes % 60) / 60, 2), 2),
            'nightHours' => floor($nightMinutes / 60),
            'nightMinutes' => (float)$nightMinutes % 60 < 10 ? (float) ($nightMinutes % 60) : (float)$nightMinutes % 60,
            'nightMinutesNew' => round(floor($nightMinutes % 60) / 60, 2),
            'nightTotal' => (float)number_format(floor($nightMinutes / 60) + round(floor($nightMinutes % 60) / 60, 2), 2),
            'saturdayHours' => floor($saturdayMinutes / 60),
            'saturdaMinutes' => (float)$saturdayMinutes % 60,
            'saturdayMinutesNew' => round(floor($saturdayMinutes % 60) / 60, 2),
            'totalSaturdayHours' => (float)number_format(floor($saturdayMinutes / 60) + round(floor($saturdayMinutes % 60) / 60, 2), 2),
            'sundayHours' => floor($sundayMinutes / 60),
            'sundayMinutes' => (float)$sundayMinutes % 60,
            'sundayMinutesNew' => round(floor($sundayMinutes % 60) / 60, 2),
            'totalSundayHours' => (float)number_format(floor($sundayMinutes / 60) + round(floor($sundayMinutes % 60) / 60, 2), 2),
        ];
    }
}
