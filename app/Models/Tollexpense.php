<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tollexpense extends Model
{
    use HasFactory;

    protected $fillable = ['general_expense_id', 'start_date', 'end_date', 'state', 'status', 'details', 'lpn_tag_number', 'rego', 'vehicle_class', 'trip_cost', 'fleet_id'];

}
