<?php

namespace App\Exports;

use App\Reports\SimpleReport;
use App\Reports\StaffTimeReport;
use App\Time\DateRange;
use App\Time\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SimpleReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    protected $report;

    public function __construct(SimpleReport $report)
    {
        $this->report = $report;
    }

    public function collection()
    {
        return $this->report->rows();
    }

    public function headings(): array
    {
        return [
            [$this->report->title()],
            [$this->report->date_range_string()],
            [],
            $this->report->headings()
        ];
    }
}
