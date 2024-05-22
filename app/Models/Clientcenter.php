<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientcenter extends Model
{
    use HasFactory;

    public function getCenterName()
    {
        return $this->hasOne(Client::class, 'id', 'clientId')->select('id', 'name');
    }

    public function getCenterState()
    {
        return $this->hasOne(States::class, 'id', 'state')->select('id', 'name');
    }
}
