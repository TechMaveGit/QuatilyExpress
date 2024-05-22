<?php

namespace App\Exports;

use App\Models\Clientrate;

class ShiftReportsExport
{
    protected $shifts;

    public function __construct($shifts)
    {
        $this->shifts = $shifts;
    }

    public function exportToCsv($filename)
    {
        $file = fopen($filename, 'w');

        // Add the headers to the CSV file
        fputcsv($file, $this->headings());

        // Add the data rows to the CSV file
        foreach ($this->collection() as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }

    public function collection()
    {
        return $this->shifts->map(function ($shift) {
            $totalHours = 0;
            if ($shift->getFinishShift) {
                $daySum = floatval($shift->getFinishShift->dayHours) ?? 0;
                $nightHours = floatval($shift->getFinishShift->nightHours) ?? 0;
                $weekendHours = floatval($shift->getFinishShift->weekendHours) ?? 0;
                $totalHours = $daySum + $nightHours + $weekendHours;
            }

            if ($shift->finishStatus == '2') {
                $extra_per_hour_rate = $shift->getDriverName->extra_per_hour_rate ?? '0';
            } else {
                $extra_per_hour_rate = 0;
            }

            $clientRate = Clientrate::where('type', $shift->vehicleType)->where('clientId', $shift->client)->first();

            $dayCharge = $clientRate->hourlyRateChargeableDays ?? 0 + $extra_per_hour_rate;
            $chargeDayShift = ($dayCharge ?? 0) * ($daySum ?? 0);

            $nightCharge = $clientRate->hourlyRateChargeableNight ?? 0 + $extra_per_hour_rate;
            $chargeNight = ($nightCharge ?? 0) * ($nightHours ?? 0);

            $saturday = 0;
            $sunday = 0;

            if ($shift->getFinishShifts && $shift->getFinishShifts->saturdayHours != '0') {
                $saturdayPy = $clientRate->hourlyRatePayableSaturday ?? 0 + $extra_per_hour_rate;
                $saturday = $saturdayPy ?? 0 * $shift->getFinishShifts->saturdayHours ?? 0;
            }
            if ($shift->getFinishShifts && $shift->getFinishShifts->sundayHours !== null && $shift->getFinishShifts->sundayHours != '0') {
                $sundayPy = $clientRate->hourlyRatePayableSunday ?? 0 + $extra_per_hour_rate;
                $sunday = floatval($sundayPy) * floatval($shift->getFinishShifts->sundayHours);
            }

            $clientCharge = $clientRate;

            $dayPy = $clientCharge->hourlyRatePayableDay ?? 0 + $extra_per_hour_rate;
            $nightPy = $clientRate->hourlyRatePayableNight ?? 0 + $extra_per_hour_rate;

            $day = $clientCharge ? $dayPy * optional($shift->getFinishShifts)->dayHours ?? 0 : 0;
            $night = $clientCharge ? $nightPy * optional($shift->getFinishShifts)->nightHours ?? 0 : 0;

            $saturdayCh = $clientRate->hourlyRateChargeableSaturday ?? 0 + $extra_per_hour_rate;
            $sundayCh = $clientRate->hourlyRateChargeableSunday ?? 0 + $extra_per_hour_rate;

            $saturdayCharge = $clientCharge ? $saturdayCh * optional($shift->getFinishShifts)->saturdayHours ?? 0 : 0;
            $sundayCharge = $clientCharge ? $sundayCh * optional($shift->getFinishShifts)->sundayHours ?? 0 : 0;

            $km = ((int) $shift?->getFinishShift?->odometerEndReading ?? 0) - ((int) $shift?->getFinishShift?->odometerStartReading ?? 0);

            return [
                'S.No' => $shift->id ?? '',
                'Client Id' => $shift->client ?? '',
                'Shift ID' => 'QE' . $shift->shiftRandId,
                'Client Name' => $shift->getClientName->name ?? 'N/A',
                'Cost' => $shift->getCostCenter->name ?? 'N/A',
                'Driver' => $shift->getDriverName->fullName ?? 'N/A',
                'Parcels Taken' => $shift->parcelsToken ?? 'N/A',
                'Parcels Delivered' => $shift->getFinishShift->parcelsDelivered ?? 'N/A',
                'REGO' => $shift->getRego->rego ?? 'N/A',
                'Vehicle Type' => $shift->getVehicleType->name ?? 'N/A',
                'State' => $shift->getStateName->name ?? 'N/A',
                'Created Date' => $shift->created_at ?? 'N/A',
                'Date Start' => $shift->shiftStartDate ?? 'N/A',
                'Time Start' => $shift->getFinishShift->startTime ?? 'N/A',
                'Date Finish' => $shift->getFinishShift->endDate ?? 'N/A',
                'Time Finish' => $shift->getFinishShift->endTime ?? 'N/A',
                'Status' => $this->getStatusText($shift->finishStatus),
                'Total Hours' => $totalHours ?? '0',
                'Amount Chargeable Day Shift' => $chargeDayShift,
                'Amount Payable Day Shift' => $day,
                'Amount Payable Night Shift' => $night,
                'Amount Chargeable Night Shift' => $chargeNight,
                'Amount Payable Weekend Shift' => $saturday ?? '0' + $sunday ?? '0',
                'Amount Chargeable Weekend Shift' => $saturdayCharge ?? '0' + $sundayCharge ?? '0',
                'Fuel Levy Payable' => $shift->getShiftMonetizeInformation->fuelLevyPayable ?? '0',
                'Fuel Levy Chargeable Fixed' => $shift->getShiftMonetizeInformation->fuelLevyChargeable ?? '0',
                'Fuel Levy Chargeable 250+' => $shift->getShiftMonetizeInformation->fuelLevyChargeable250 ?? '0',
                'Fuel Levy Chargeable 400+' => $shift->getShiftMonetizeInformation->fuelLevyChargeable400 ?? '0',
                'Extra Payable' => $shift->getShiftMonetizeInformation->extraPayable ?? '0',
                'Extra Chargeable' => $shift->getShiftMonetizeInformation->extraChargeable ?? '0',
                'Total Chargeable' => $shift->getShiftMonetizeInformation->totalChargeable ?? '0',
                'Odometer Start' => $shift->getFinishShift->odometerStartReading ?? '0',
                'Odometer End' => $shift->getFinishShift->odometerEndReading ?? '0',
                'Total Payable' => round($shift->payAmount, 2) ?? '0',
                'Traveled KM' => $km ?? '0',
                'Comment' => $shift->getFinishShift->comments ?? 'N/A',
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Client Id',
            'Shift ID',
            'Client Name',
            'Cost',
            'Driver',
            'Parcels Taken',
            'Parcels Delivered',
            'REGO',
            'Vehicle Type',
            'State',
            'Created Date',
            'Date Start',
            'Time Start',
            'Date Finish',
            'Time Finish',
            'Status',
            'Total Hours',
            'Amount Chargeable Day Shift',
            'Amount Payable Day Shift',
            'Amount Payable Night Shift',
            'Amount Chargeable Night Shift',
            'Amount Payable Weekend Shift',
            'Amount Chargeable Weekend Shift',
            'Fuel Levy Payable',
            'Fuel Levy Chargeable Fixed',
            'Fuel Levy Chargeable 250+',
            'Fuel Levy Chargeable 400+',
            'Extra Payable',
            'Extra Chargeable',
            'Total Chargeable',
            'Odometer Start',
            'Odometer End',
            'Total Payable',
            'Traveled KM',
            'Comment',
        ];
    }

    public function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Created';
            case 1:
                return 'In Progress';
            case 2:
                return 'To Be Approved';
            case 3:
                return 'Approved';
            case 4:
                return 'Rejected';
            case 5:
                return 'Paid';
            case 6:
                return 'Already Paid';
            default:
                return 'Unknown';
        }
    }
}
