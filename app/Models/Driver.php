<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory ,Notifiable;

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
