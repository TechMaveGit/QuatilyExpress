<?php

namespace App\Imports;

use App\Models\FinishShift;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ShiftsImport
{
    /**
     * The model method is where each row of the spreadsheet is mapped to the model's attributes.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $created_at = Date::excelToDateTimeObject($row['date_finish'])->format('Y/m/d H:i:s');
        $shiftRandId = preg_replace('/[^0-9]/', '', $row['id']);

        // Assuming Shift::where updates an existing model. If not, you'll need to adjust this.
        $shift = Shift::where('shiftRandId', $shiftRandId)->first();
        if ($shift) {
            $shift->update([
                'payAmount' => $row['total_payable'],
                'created_at' => $created_at,
            ]);
        }

        // Assuming FinishShift::where updates an existing model. If not, you might need to adjust this.
        $finishShift = FinishShift::where('shiftId', $shiftRandId)->first();
        if ($finishShift) {
            $finishShift->update([
                'totalHours' => $row['total_hours'],
                'amount_payable_day_shift' => $row['amount_payable_day_shift'],
                'amount_chargeable_day_shift' => $row['amount_chargeable_day_shift'],
                'odometerStartReading' => $row['odometer_start'] ?? 0,
                'odometerEndReading' => $row['odometer_end'] ?? 0,
            ]);
        }

        // Assuming you are updating another table for the monetize information.
        DB::table('shiftMonetizeInformation')->where('shiftId', $shiftRandId)->update([
            'fuelLevyPayable' => $row['fuel_levy_pay'],
            'fuelLevyChargeable' => $row['fuel_levy_charge'],
            'fuelLevyChargeable250' => $row['fuel_levy_chargeable'],
            'fuelLevyChargeable400' => $row['fuel_levy_chargeable400'],
            'extraPayable' => $row['extra_payable'],
            'extraChargeable' => $row['extra_chargeable'],
            'totalChargeable' => $row['total_chargeable'],
        ]);

        // Return null because we're not directly creating a model in this method.
        return null;
    }

    /**
     * Configuration to use the heading row as attribute keys.
     *
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Batch inserts to optimize the import.
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Read the data in chunks to optimize memory usage.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
