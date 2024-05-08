<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DB;
use Auth;


class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable;
    // protected $guard = 'admin';composer require livewire/livewire


    public function get_role() {
        $permission = DB::table('role_has_permissions')->where('role_id',Auth::guard('adminLogin')->user()->role_id)->get(['permission_id']);
        return $permission;
  }




    protected $fillable = [
        'name', 'email', 'password','role_id','status','added_date',
    ];

    protected $hidden = [
      'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
      return [];
    }
}
