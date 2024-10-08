<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'driverId','shiftRandId','state','client','costCenter','base','vehicleType','rego','odometer','scanner_id','parcelsToken','status','chageAmount','payAmount','shiftStatus','finishStatus','optShift','comment','approval_reason','shiftStartDate','finishDate','createdDate','startlatitude','startlongitude','endlatitude','endlongitude','startaddress','endaddress','priceOverRideStatus','is_missed_shift','client_data_json','extra_rate_person'
    ];

    public function getClientName()
    {
        return $this->hasOne(Client::class, 'id', 'client');
    }

    public function getCostCenter()
    {
        return $this->hasOne(Clientcenter::class, 'id', 'costCenter');
    }

    public function getVehicalsRego()
    {
        return $this->hasOne(Vehical::class, 'id', 'rego');
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

    public function getClientCharges()
    {
        return $this->hasMany(Clientrate::class, 'type', 'vehicleType');
    }

    public function getClientReportCharge()
    {
        return $this->hasOne(Clientrate::class, 'clientId', 'client');
    }

    public function getPersonRates()
    {
        return $this->hasOne(Personrates::class, 'personId', 'driverId');
    }

    // public function personExtraRate()
    // {
    //     return $this->hasOne(Driver::class, 'personId', 'driverId');
    // }

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
        return $this->hasMany(Clientbase::class, 'clientId', 'id');
    }

    public function getClientNm()
    {
        return $this->hasOne(Client::class, 'id', 'client')->select('id', 'name', 'adminCharge', 'driverPay');
    }

    public function getbase()
    {
        return $this->hasOne(Clientbase::class, 'id', 'base');
    }

    public function getShiftMonetizeInformation()
    {
        return $this->hasOne(shiftMonetizeInformation::class, 'shiftId', 'id');
    }

    public function getFinishShift()
    {
        return $this->hasOne(Finishshift::class, 'shiftId', 'id');
    }

    public function getRego()
    {
        return $this->hasOne(Vehical::class, 'id', 'rego');
    }
}
