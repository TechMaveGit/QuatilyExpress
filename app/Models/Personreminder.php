<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personreminder extends Model
{
    use HasFactory;
    public function getReminder()
    {
        return $this->hasOne(Reminders::class, 'id', 'reminderType');
    }

    protected $fillable = ['personId','reminderType','status'] ;
}
