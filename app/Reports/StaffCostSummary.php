<?php


namespace App\Reports;


use App\Time\Session;
use App\Time\WorkDay;
use App\User;
use Carbon\CarbonPeriod;

class StaffCostSummary
{
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function toArray()
    {
        $users = User::all();

        $staff = $users
            ->map
            ->costReport($this->start, $this->end)
            ->values()
            ->all();

        return [
            'start_date' => $this->start->format('Y-m-d'),
            'end_date'   => $this->end->format('Y-m-d'),
            'staff'      => $this->staffSummaries(),
        ];
    }

    private function staffSummaries()
    {
        $users = User::all();

        return $users
            ->map
            ->costReport($this->start, $this->end)
            ->values()
            ->all();
    }

    public function save()
    {
        $report = StaffCostReport::create([
            'start_date' => $this->start,
            'end_date'   => $this->end,
        ]);

        collect($this->staffSummaries())->each(function ($summary) use ($report) {
            $report->entries()->create([
                'user_id'        => $summary['id'],
                'total_hours'    => $summary['total_hours'],
                'overtime_hours' => $summary['overtime_hours'],
                'hourly_rate'    => $summary['hourly_rate'],
                'cost'           => $summary['cost'],
            ]);
        });
    }


}