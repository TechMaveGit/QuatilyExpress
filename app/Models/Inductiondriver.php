<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inductiondriver extends Model
{
    use HasFactory;

      public function getDriver()
    {
        return $this->hasOne(Driver::class, 'id', 'driverId');

    }


}
