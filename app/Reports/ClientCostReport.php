<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Model;

class ClientCostReport extends Model
{
    protected $fillable = ['start_date', 'end_date'];

    protected $dates = ['start_date', 'end_date'];

    public function entries()
    {
        return $this->hasMany(ClientCostEntry::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'date_range' => $this->start_date->format('M, Y'),
            'entries_count' => $this->entries()->where('total_hours', '>', 0)->count(),
            'total_hours' => $this->entries->sum('total_hours'),
            'overtime_hours' => $this->entries->sum('overtime_hours'),
            'total_cost' => number_format($this->entries->sum('cost')),
            'estimated_revenue' => number_format($this->entries->sum('annual_revenue') / 12),
            'entries' => $this->entries->sortByDesc('cost')->toArray(),
        ];
    }
}
