<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driverresponsible extends Model
{
    use HasFactory;

    public function getDriverResponsible()
    {
        return $this->hasOne(Driver::class, 'id', 'driverResponsible');
    }
}
