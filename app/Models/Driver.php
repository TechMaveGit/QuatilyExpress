<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory ,Notifiable;
    
    protected $fillable = ['fullName','userName','surname','mobileNo','dialCode','email','dob','phonePrincipal','phoneAux','tfn','abn','selectPersonType','documentType','selectDocument','password','profile_image','driving_license','visa','role_id','traffic_history','police_chceck','driving_license_issue_date','driving_date_expiry_date','visa_issue_date','visa_expiry_date','traffic_history_issue_date','traffic_history_expiry_date','police_chceck_issue_date','police_chceck_expiry_date','driverInspections','status','otp','rego','extra_rate_per_hour'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getaddress()
    {
        return $this->hasMany(Personaddress::class, 'personId', 'id');
    }

    public function allshift()
    {
        return $this->hasMany(Shift::class, 'driverId', 'id');
    }

    public function getreminder()
    {
        return $this->hasMany(Personreminder::class, 'personId', 'id');
    }

    public function getRates()
    {
        return $this->hasMany(Clientcenter::class, 'clientId', 'id');
    }

    public function getDriverInspection()
    {
        return $this->hasOne(Clientcenter::class, 'clientId', 'id');
    }

    public function roleName()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id')->select('id', 'name');
    }
}
