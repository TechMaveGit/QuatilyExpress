<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['vehical_type', 'date', 'person_name', 'person_approve', 'cost', 'rego', 'description'];

}
