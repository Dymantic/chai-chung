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

    public function toArray()
    {
        return [
            'id'             => $this->id,
            'created_at'     => $this->created_at->format('Y-m-d'),
            'start_date'     => $this->start_date->format('Y-m-d'),
            'end_date'       => $this->end_date->format('Y-m-d'),
            'date_range'     => $this->start_date->format('M, Y'),
            'entries_count'  => $this->entries->count(),
            'total_hours'    => $this->entries->sum('total_hours'),
            'overtime_hours' => $this->entries->sum('overtime_hours'),
            'cost'           => number_format($this->entries->sum('cost')),
            'entries'        => $this->entries->sortByDesc('cost')->toArray()
        ];
    }
}
