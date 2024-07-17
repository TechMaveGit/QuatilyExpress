<?php

namespace App\Exports;

use App\Models\Clientrate;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ShiftReportsExport
{
    protected $shifts;

    public function __construct($shifts)
    {
        $this->shifts = $shifts;
    }

    public function exportToXls()
    {
        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();

       
        // $headers = $this->generateHeaders();
        // $sheet->fromArray($headers, NULL, 'A1');

        $data = $this->collection();
        dd($data);
        // $sheet->fromArray($data, NULL, 'A2');

        // $writer = new Xls($spreadsheet);

        // $tempFile = tempnam(sys_get_temp_dir(), 'shift_report');
        // $writer->save($tempFile);

        // return $tempFile;
    }

    protected function generateHeaders()
    {

        $driverRole = Auth::guard('adminLogin')->user()->role_id;

        if ($driverRole == 33) {
            return [
                'Shift ID',
                'Client Name',
                'Cost',
                'Driver',
                'Scanner ID',
                'Base',
                'Parcels Taken',
                'Parcels Delivered',
                'Outstanding Parcels',
                'Vehicle',
                'Vehicle Type',
                'State',
                'Date Start',
                'Time Start',
                'Date Finish',
                'Time Finish',
                'Status',
                'Total Hours Morning Shift',
                'Total Hours Night Shift',
                'Total Hours Weekend Shift',
                'Total Payable',
                'Traveled KM'
            ];
        } else {
            return [
                'ID',
                'Client',
                'Cost',
                'Driver',
                'Scanner ID',
                'Base',
                'Parcels Taken',
                'Parcels Delivered',
                'Outstanding Parcels',
                'Vehicle',
                'Vehicle Type',
                'State',
                'Date Start',
                'Time Start',
                'Date Finish',
                'Time Finish',
                'Status',
                'Total Hours',
                'Hours Morning Shift',
                'Hours Night Shift',
                'Hours Weekend Shift',
                'Amount Payable Day Shift',
                'Amount Chargeable Day Shift',
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
                'Total Payable',
                'Total Chargeable',
                'Odometer Start',
                'Odometer End',
                'Traveled KM',
                'Comments',
                'Approved Reason',
                'Driver Rate',
                'Mobile Date Start',
                'Mobile Date Finish',
            ];
        }
    }

    // public function exportToCsv()
    // {
    //     $content = $this->generateCsvHeaders() . "\r\n";
    //     foreach ($this->collection() as $index => $row) {
    //         $content .= $this->generateCsvRow($index + 1, $row) . "\r\n";
    //     }
    //     return $content;
    // }

    // protected function generateCsvHeaders()
    // {
    //     return implode(',', [
    //         'ID',
    //         'Client',
    //         'Cost',
    //         'Driver',
    //         'Scanner ID',
    //         'Base',
    //         'Parcels Taken',
    //         'Parcels Delivered',
    //         'Outstanding Parcels',
    //         'Vehicle',
    //         'Vehicle Type',
    //         'State',
    //         'Date Start',
    //         'Time Start',
    //         'Date Finish',
    //         'Time Finish',
    //         'Status',
    //         'Total Hours',
    //         'Hours Morning Shift',
    //         'Hours Night Shift',
    //         'Hours Weekend Shift',
    //         'Amount Payable Day Shift',
    //         'Amount Chargeable Day Shift',
    //         'Amount Payable Night Shift',
    //         'Amount Chargeable Night Shift',
    //         'Amount Payable Weekend Shift',
    //         'Amount Chargeable Weekend Shift',
    //         'Fuel Levy Payable',
    //         'Fuel Levy Chargeable Fixed',
    //         'Fuel Levy Chargeable 250+',
    //         'Fuel Levy Chargeable 400+',
    //         'Extra Payable',
    //         'Extra Chargeable',
    //         'Total Payable',
    //         'Total Chargeable',
    //         'Odometer Start',
    //         'Odometer End',
    //         'Traveled KM',
    //         'Comments',
    //         'Approved Reason',
    //         'Driver Rate',
    //         'Mobile Date Start',
    //         'Mobile Date Finish',
    //     ]);
    // }

    // protected function generateCsvRow($index, $row)
    // {
    //     return implode(',', [
    //         $row['Shift ID'],
    //         $row['Client Name'],
    //         $row['Cost'],
    //         $row['Driver'],
    //         $row['Scanner Id'],
    //         $row['Base'],
    //         $row['Parcels Taken'],
    //         $row['Parcels Delivered'],
    //         $row['Outstanding Parcels'],
    //         $row['REGO'],
    //         $row['Vehicle Type'],
    //         $row['State'],
    //         $row['Date Start'],
    //         $row['Time Start'],
    //         $row['Date Finish'],
    //         $row['Time Finish'],
    //         $row['Status'],
    //         $row['Total Hours'],
    //         $row['Hours Morning Shift'],
    //         $row['Hours Night Shift'],
    //         $row['Hours Weekend Shift'],
    //         $row['Amount Payable Day Shift'],
    //         $row['Amount Chargeable Day Shift'],
    //         $row['Amount Payable Night Shift'],
    //         $row['Amount Chargeable Night Shift'],
    //         $row['Amount Payable Weekend Shift'],
    //         $row['Amount Chargeable Weekend Shift'],
    //         $row['Fuel Levy Payable'],
    //         $row['Fuel Levy Chargeable Fixed'],
    //         $row['Fuel Levy Chargeable 250+'],
    //         $row['Fuel Levy Chargeable 400+'],
    //         $row['Extra Payable'],
    //         $row['Extra Chargeable'],
    //         $row['Total Payable'],
    //         $row['Total Chargeable'],
    //         $row['Odometer Start'],
    //         $row['Odometer End'],
    //         $row['Traveled KM'],
    //         $row['Comment'],
    //         $row['Approved Reason'],
    //         $row['Driver Rate'],
    //         $row['Mobile Date Start'],
    //         $row['Mobile Date Finish'],
    //     ]);
    // }

    public function collection()
    {

        $driverRole = Auth::guard('adminLogin')->user()->role_id;

        return $this->shifts->map(function ($shift) use ($driverRole) {
            $totalHours = 0;
            if ($shift->getFinishShift) {
                $daySum = floatval($shift->getFinishShift->dayHours) ?? 0;
                $nightHours = floatval($shift->getFinishShift->nightHours) ?? 0;
                $weekendHours = floatval($shift->getFinishShift->weekendHours) ?? 0;
                $totalHours = $daySum + $nightHours + $weekendHours;
            }

            // if ($shift->finishStatus == '2') {
                $extra_per_hour_rate = $shift->getDriverName->extra_rate_per_hour ?? 0;
                // dd($shift,$shift->getDriverName);
            // } else {
            //     $extra_per_hour_rate = 0;
            // }

            $clientRate = Clientrate::where('type', $shift->vehicleType)->where('clientId', $shift->client)->first();

            $dayCharge = $clientRate->hourlyRateChargeableDays ?? 0 + $extra_per_hour_rate;
            $chargeDayShift = ($dayCharge ?? 0) * ($daySum ?? 0);

            $nightCharge = $clientRate->hourlyRateChargeableNight ?? 0 + $extra_per_hour_rate;
            $chargeNight = ($nightCharge ?? 0) * ($nightHours ?? 0);

            $saturday = 0;
            $sunday = 0;

            if ($shift->getFinishShifts && $shift->getFinishShifts->saturdayHours != 0) {
                $saturdayPy = $clientRate->hourlyRatePayableSaturday ?? 0 + $extra_per_hour_rate;
                $saturday = $saturdayPy ?? 0 * $shift->getFinishShifts->saturdayHours ?? 0;
            }
            if ($shift->getFinishShifts && $shift->getFinishShifts->sundayHours !== null && $shift->getFinishShifts->sundayHours != 0) {
                $sundayPy = $clientRate->hourlyRatePayableSunday ?? 0 + $extra_per_hour_rate;
                $sunday = floatval($sundayPy) * floatval($shift->getFinishShifts->sundayHours);
            }

            // dd($shift);

            $clientCharge = $clientRate;

            $dayPy = ($clientCharge->hourlyRatePayableDay ?? 0) + $extra_per_hour_rate;
            $nightPy = ($clientRate->hourlyRatePayableNight ?? 0) + $extra_per_hour_rate;

            $day = $clientCharge ? $dayPy * optional($shift->getFinishShifts)->dayHours ?? 0 : 0;
            $night = $clientCharge ? $nightPy * optional($shift->getFinishShifts)->nightHours ?? 0 : 0;

            // dd($day);

            $saturdayCh = $clientRate->hourlyRateChargeableSaturday ?? 0 + $extra_per_hour_rate;
            $sundayCh = $clientRate->hourlyRateChargeableSunday ?? 0 + $extra_per_hour_rate;

            $saturdayCharge = $clientCharge ? $saturdayCh * optional($shift->getFinishShifts)->saturdayHours ?? 0 : 0;
            $sundayCharge = $clientCharge ? $sundayCh * optional($shift->getFinishShifts)->sundayHours ?? 0 : 0;

            $km = ((int) $shift?->getFinishShift?->odometerEndReading ?? 0) - ((int) $shift?->getFinishShift?->odometerStartReading ?? 0);

            if ($driverRole == 33) {
                return [
                    'Shift ID' => 'QE' . $shift->shiftRandId,
                    'Client Name' => $shift->getClientName->name ?? 'N/A',
                    'Cost' => $shift->getCostCenter->name ?? 'N/A',
                    'Driver' => $shift->getDriverName->fullName ?? 'N/A',
                    'Scanner ID' => $shift->scanner_id ?? 'N/A',
                    'Base' => $shift->base ?? 'N/A',
                    'Parcels Taken' => $shift->parcelsToken ?? 0,
                    'Parcels Delivered' => $shift->getFinishShift->parcelsDelivered ?? 0,
                    'Outstanding Parcels' => (($shift->parcelsToken ?? 0) - ($shift->getFinishShift->parcelsDelivered ?? 0)),
                    'Vehicle' => $shift->getRego->rego ?? 'N/A',
                    'Vehicle Type' => $shift->getVehicleType->name ?? 'N/A',
                    'State' => $shift->getStateName->name ?? 'N/A',
                    'Date Start' => $shift->getFinishShift->startDate ? date('d-m-Y', strtotime($shift->getFinishShift->startDate)) : 'N/A',
                    'Time Start' => $shift->getFinishShift->startTime ?? 'N/A',
                    'Date Finish' => $shift->getFinishShift->endDate ? date('d-m-Y', strtotime($shift->getFinishShift->endDate)) : 'N/A',
                    'Time Finish' => $shift->getFinishShift->endTime ?? 'N/A',
                    'Status' => $this->getStatusText($shift->finishStatus),
                    'Total Hours Morning Shift' => $shift->getFinishShifts->dayHours ?? 0,
                    'Total Hours Night Shift' => $shift->getFinishShifts->nightHours ?? 0,
                    'Total Hours Weekend Shift' => ($shift->getFinishShifts->dayHours ?? 0) + ($shift->getFinishShifts->nightHours ?? 0),
                    'Total Payable' => round(($day+$night+($saturday ?? 0 + $sunday ?? 0)+($shift->getShiftMonetizeInformation->fuelLevyPayable??0)+($shift->getShiftMonetizeInformation->extraPayable??0)), 2) ?? 0,
                    'Traveled KM' => $km ?? 0
                ];
            } else {
                return [
                    'Shift ID' => 'QE' . $shift->shiftRandId,
                    'Client Name' => $shift->getClientName->name ?? 'N/A',
                    'Cost' => $shift->getCostCenter->name ?? 'N/A',
                    'Driver' => $shift->getDriverName->fullName ?? 'N/A',
                    'Scanner Id' => $shift->scanner_id ?? 'N/A',
                    'Base' => $shift->base ?? 'N/A',
                    'Parcels Taken' => $shift->parcelsToken ?? 0,
                    'Parcels Delivered' => $shift->getFinishShift->parcelsDelivered ?? 0,
                    'Outstanding Parcels' => (($shift->parcelsToken ?? 0) - ($shift->getFinishShift->parcelsDelivered ?? 0)),
                    'REGO' => $shift->getRego->rego ?? 'N/A',
                    'Vehicle Type' => $shift->getVehicleType->name ?? 'N/A',
                    'State' => $shift->getStateName->name ?? 'N/A',
                    'Date Start' => $shift->getFinishShift->startDate ? date('d-m-Y', strtotime($shift->getFinishShift->startDate)) : 'N/A',
                    'Time Start' => $shift->getFinishShift->startTime ?? 'N/A',
                    'Date Finish' => $shift->getFinishShift->endDate ? date('d-m-Y', strtotime($shift->getFinishShift->endDate)) : 'N/A',
                    'Time Finish' => $shift->getFinishShift->endTime ?? 'N/A',
                    'Status' => $this->getStatusText($shift->finishStatus),
                    'Total Hours' => $totalHours ?? 0,
                    'Hours Morning Shift' => $shift->getFinishShifts->dayHours ?? 0,
                    'Hours Night Shift' => $shift->getFinishShifts->nightHours ?? 0,
                    'Hours Weekend Shift' => ($shift->getFinishShifts->weekendHours ?? 0),
                    'Amount Chargeable Day Shift' => $chargeDayShift,
                    'Amount Payable Day Shift' => $day??0,
                    'Amount Payable Night Shift' => $night??0,
                    'Amount Chargeable Night Shift' => $chargeNight??0,
                    'Amount Payable Weekend Shift' => $saturday ?? 0 + $sunday ?? 0,
                    'Amount Chargeable Weekend Shift' => $saturdayCharge ?? 0 + $sundayCharge ?? 0,
                    'Fuel Levy Payable' => $shift->getShiftMonetizeInformation->fuelLevyPayable ?? 0,
                    'Fuel Levy Chargeable Fixed' => $shift->getShiftMonetizeInformation->fuelLevyChargeable ?? 0,
                    'Fuel Levy Chargeable 250+' => $shift->getShiftMonetizeInformation->fuelLevyChargeable250 ?? 0,
                    'Fuel Levy Chargeable 400+' => $shift->getShiftMonetizeInformation->fuelLevyChargeable400 ?? 0,
                    'Extra Payable' => $shift->getShiftMonetizeInformation->extraPayable ?? 0,
                    'Extra Chargeable' => $shift->getShiftMonetizeInformation->extraChargeable ?? 0,
                    'Total Payable' => round(($day+$night+($saturday ?? 0 + $sunday ?? 0)+($shift->getShiftMonetizeInformation->fuelLevyPayable??0)+($shift->getShiftMonetizeInformation->extraPayable??0)), 2) ?? 0,
                    'Total Chargeable' => $shift->getShiftMonetizeInformation->totalChargeable ?? 0,
                    'Odometer Start' => $shift->getFinishShift->odometerStartReading ?? 0,
                    'Odometer End' => $shift->getFinishShift->odometerEndReading ?? 0,
                    'Traveled KM' => $km ?? 0,
                    'Comment' => $shift->getFinishShift->comments ?? 'N/A',
                    'Approved Reason' => $shift->approval_reason ?? 'N/A',
                    'Driver Rate' => $extra_per_hour_rate ?? 0,
                    'Mobile Date Start' => $shift->createdDate ? date('d-m-Y H:i:s', strtotime($shift->createdDate)) : 'N/A',
                    'Mobile Date Finish' => $shift->getFinishShift->submitted_at ? date('d-m-Y H:i:s', strtotime($shift->getFinishShift->submitted_at)) : 'N/A',
                ];
            }
        })->toArray();
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
