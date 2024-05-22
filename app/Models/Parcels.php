<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model
{
    use HasFactory;

    public function ParcelImage()
    {
        return $this->hasOne(Addparcelimage::class, 'parcelId', 'id');
    }

    public function getParcelImage()
    {
        return $this->hasMany(Addparcelimage::class, 'parcelId', 'id');
    }
}
