<?php


namespace App\Reports;


use App\Time\DateRange;
use Illuminate\Support\Facades\DB;

class StaffTimeCostReport implements SimpleReport
{

    private $report;

    public function __construct(StaffCostReport $report)
    {
        $this->report = $report;
    }

    public function date_range_string()
    {
        return $this->report->start_date->format('Y-m-d (D)') . " - " . $this->report->end_date->format('Y-m-d (D)');
    }

    public function headings()
    {
        return [
            '代號',
            '姓名',
            '總時數(小時)',
            '加班總時數(小時)',
            '時薪',
            '成本'
        ];

    }

    public function rows()
    {
        $this->report->load(['entries', 'entries.user']);

        return $this->report->entries->sortByDesc('cost')
            ->map(function($entry) {
                return [
                    $entry->user->user_code,
                    $entry->user->name,
                    $entry->total_hours,
                    $entry->overtime_hours,
                    $entry->hourly_rate,
                    number_format($entry->cost),
                ];
            })->values();
    }

    public function title()
    {
        return '員工成本報告';
    }

    public function slug()
    {
        return 'staff_cost_' . $this->report->start_date->format('Ymd') . '_' . $this->report->end_date->format('Ymd');
    }
}