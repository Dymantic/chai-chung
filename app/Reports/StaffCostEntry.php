<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Model;

class StaffCostEntry extends Model
{
    protected $fillable = [
        'user_id',
        'total_hours',
        'overtime_hours',
        'hourly_rate',
        'cost'
    ];
}
