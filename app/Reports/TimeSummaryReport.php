<?php


namespace App\Reports;


use App\Exports\SheetExport;

class TimeSummaryReport implements MultisheetReport
{

    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function sheets()
    {
        $timesheet = new TimesheetReport($this->from, $this->to);
        $daily_hours = new DailyHoursReport($this->from, $this->to);

        return [new SheetExport($timesheet), new SheetExport($daily_hours)];
    }

    public function slug()
    {
        $from = $this->from->format('m_d_Y');
        $to = $this->to->format('m_d_Y');

        return "timesheet_{$from}_to_{$to}";
    }
}
