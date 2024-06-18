<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['vehical_type', 'date', 'person_name', 'person_approve', 'cost', 'rego', 'description'];

    public function personName()
    {
        return $this->hasOne(Driver::class, 'id', 'person_name')->select('id', 'fullName','email');
    }

    public function personApprove()
    {
        return $this->hasOne(Driver::class, 'id', 'person_approve')->select('id', 'fullName','email');
    }
}
