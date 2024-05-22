<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['clientId', 'name', 'shortName', 'acn', 'abn', 'state', 'phonePrinciple', 'mobilePhone', 'phomneAux', 'faxPhone', 'website', 'notes'];

    public function getaddress()
    {
        return $this->hasMany(Clientaddress::class, 'clientId', 'id');
    }

    public function getrates()
    {
        return $this->hasMany(Clientrate::class, 'clientId', 'id');

    }

    public function getCenter()
    {
        return $this->hasMany(Clientcenter::class, 'clientId', 'id')->where('status', '1');
    }

    public function getCenterState()
    {
        return $this->hasOne(States::class, 'id', 'state')->select('id', 'name');
    }

    public function getState()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }
}
