<?php

namespace App\Reports;

use App\User;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'user_code' => $this->user->user_code,
            'total_hours' => $this->total_hours,
            'overtime_hours' => $this->overtime_hours,
            'hourly_rate' => $this->hourly_rate,
            'cost' => $this->cost,
        ];
    }
}
