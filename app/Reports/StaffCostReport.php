<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Model;

class StaffCostReport extends Model
{
    protected $fillable = ['start_date', 'end_date'];

    protected $dates = ['start_date', 'end_date'];

    public function entries()
    {
        return $this->hasMany(StaffCostEntry::class);
    }
}
