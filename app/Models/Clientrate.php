<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientrate extends Model
{
    use HasFactory;

    public function getType()
    {
        return $this->hasOne(Type::class, 'id', 'type');
    }

    public function getClientType()
    {
        return $this->hasOne(Type::class, 'id', 'type')->select('id','name');
    }

    // public function getClientBase()
    // {
    //     return $this->hasMany(Type::class, 'id', 'type')->select('id','name');
    // }


}
