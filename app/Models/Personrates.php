<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personrates extends Model
{
    use HasFactory;

    public function getRates()
    {
        return $this->hasOne(self::class, 'id', 'reminderType');
    }
}
