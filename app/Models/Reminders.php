<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    use HasFactory;

    public function getReminderName()
    {
        return $this->hasOne(Client::class, 'id', 'client')->select('id','name');
    }
}
