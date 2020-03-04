<?php


namespace App\Exports;


use App\Reports\MultisheetReport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultisheetExport implements WithMultipleSheets
{

    use Exportable;

    private $report;

    public function __construct(MultisheetReport $report)
    {
        $this->report = $report;
    }


    public function sheets(): array
    {
        return $this->report->sheets();
    }

    public function exportName()
    {
        return "{$this->report->slug()}.xlsx";
    }
}
