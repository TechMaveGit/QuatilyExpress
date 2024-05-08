<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Vehical extends Model

{

    use HasFactory;

    protected $fillable = ['selectType','vehicalType','rego','odometer','modelName','driverResponsible','controlVehicle','regoDueDate','serviceDueDate','inspectionDueDate'];



    public function getDriverRsp()
    {
        return $this->hasOne(Driver::class, 'id', 'driverResponsible')->select('id','userName','email');
    }
    public function getDriverRego()
    {
        return $this->hasOne(Driver::class, 'id', 'driverResponsible')->select('id','userName','email');
    }

    public function getShiftRego()
    {
        return $this->hasOne(Shift::class, 'rego', 'id')->select('id','driverId','client','rego');
    }

    public function getTollexpenses()
    {
        return $this->hasOne(Tollexpense::class, 'rego', 'rego')->select('id','trip_cost');
    }

    public function getVehicleType()
    {
        return $this->hasOne(Type::class, 'id', 'vehicalType');
    }

}

