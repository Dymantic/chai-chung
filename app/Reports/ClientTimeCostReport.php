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
            '代號',
            '姓名',
            '總時數(小時)',
            '加班總時數(小時)',
            'Annual Revenue',
            'Cost'
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
        return 'Client Time cost report';
    }

    public function slug()
    {
        return 'client_cost_' . $this->report->start_date->format('Ymd') . '_' . $this->report->end_date->format('Ymd');
    }
}