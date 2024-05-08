<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missedshift extends Model
{
    use HasFactory;

    public function getClientName()
    {
        return $this->hasOne(Client::class, 'id', 'client');
    }

    public function getCostCenter()
    {
        return $this->hasOne(Clientcenter::class, 'id', 'costCenter');
    }

    public function getStateName()
    {
        return $this->hasOne(States::class, 'id', 'state');
    }

    public function getVehicleType()
    {
        return $this->hasOne(Type::class, 'id', 'vehicleType');
    }

    public function getClientRate()
    {
        return $this->hasOne(Clientrate::class, 'id', 'client');
    }



    public function getClientVehicleRates()
    {
        return $this->hasOne(Clientrate::class, 'type', 'vehicleType');
    }



    public function getDriverName()
    {
        return $this->hasOne(Driver::class, 'id', 'driverId');
    }



    public function getClientCharge()
    {
        return $this->hasOne(Clientrate::class, 'type', 'vehicleType');
    }


    public function getFinishShifts()
    {
        return $this->hasOne(Finishshift::class, 'shiftId', 'id');
    }


     public function getParcel()
    {
        return $this->hasMany(Parcels::class, 'shiftId', 'id');
    }

    public function getClientBase()
    {
        return $this->hasMany(ClientBase::class, 'clientId', 'id');
    }







}
