<?php

namespace App\Exports;

use App\Time\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffTimeReportExport implements FromCollection, WithHeadings
{

    protected $report;

    public function __construct($date_range)
    {
        $this->report = Session::staffTimeReport($date_range);
    }

    public function collection()
    {
        return collect($this->report['rows']);
    }

    public function headings(): array
    {
        return [
            ['Staff time report for date range'],
            ['ID', 'Name', 'Time (hrs)', 'Overtime (hrs)']
        ];
    }
}
