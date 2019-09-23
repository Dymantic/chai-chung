<?php


namespace App\Reports;


use App\Leave\LeaveRequest;
use Carbon\Carbon;

class AnnualLeaveReport implements SimpleReport
{

    private $summary;
    private $year;

    public function __construct($year)
    {
        $this->year = $year;
        $this->summary = LeaveRequest::annualSummary($year);
    }

    public function slug()
    {
        return "annual_leave_report_{$this->year}";
    }

    public function rows()
    {
        return collect($this->summary['data']);
    }

    public function headings()
    {
        return $this->summary['head']['columns'];
    }

    public function date_range_string()
    {
        return "1/1 {$this->year} - 12/31 {$this->year}";
    }

    public function title()
    {
        return $this->summary['head']['title'];
    }
}