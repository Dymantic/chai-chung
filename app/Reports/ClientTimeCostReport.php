<?php


namespace App\Reports;


class ClientTimeCostReport implements SimpleReport
{
    private $report;

    public function __construct(ClientCostReport $report)
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
            '客戶代號',
            '客戶姓名',
            '總時數(小時)',
            '加班總時數(小時)',
            '每年收入',
            '所需成本'
        ];

    }

    public function rows()
    {
        $this->report->load(['entries', 'entries.client']);

        return $this
            ->report
            ->entries
            ->filter(function($entry) {
                return $entry->total_hours > 0;
            })
            ->sortByDesc('cost')
            ->map(function ($entry) {
                return [
                    $entry->client->client_code,
                    $entry->client->name,
                    $entry->total_hours,
                    $entry->overtime_hours,
                    $entry->annual_revenue,
                    number_format($entry->cost),
                ];
            })->values();
    }

    public function title()
    {
        return '客戶成本報告';
    }

    public function slug()
    {
        return 'client_cost_' . $this->report->start_date->format('Ymd') . '_' . $this->report->end_date->format('Ymd');
    }
}