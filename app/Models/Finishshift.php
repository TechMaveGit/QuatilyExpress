<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishshift extends Model
{
    use HasFactory;

    protected $fillable = [
        'shiftId','driverId','odometerStartReading','odometerEndReading','startDate','endDate','dayHours','nightHours','totalHours','saturdayHours','sundayHours','weekendHours','startTime','endTime','amount_payable_day_shift','amount_chargeable_day_shift','amount_payable_night_shift','amount_chargeable_night_shift','amount_payable_weekend_shift','amount_chargeable_weekend_shift','parcelsTaken','parcelsDelivered','addPhoto','status'
    ];

}
