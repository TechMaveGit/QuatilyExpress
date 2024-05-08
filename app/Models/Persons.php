<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persons extends Model
{
    use HasFactory;
    public function getaddress()
    {
        return $this->hasMany(Personaddress::class, 'personId', 'id');
    }

    public function getreminder()
    {
        return $this->hasMany(Personreminder::class, 'personId', 'id');
     }

    public function getRates()
    {
        return $this->hasMany(Clientcenter::class, 'clientId', 'id');

    }

}
