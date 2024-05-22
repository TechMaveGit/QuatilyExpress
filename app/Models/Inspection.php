<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    public function getIndectionDriver()
    {
        return $this->hasMany(Inductiondriver::class, 'induction_id', 'id');
    }

    public function getAppDriver()
    {
        return $this->hasOne(Driver::class, 'id', 'driverId');
    }

    public function getVehicleRego()
    {
        return $this->belongsTo(Vehical::class, 'regoNumber', 'id');
    }
}
