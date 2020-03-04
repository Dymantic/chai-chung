<?php


namespace App\Exports;


use App\Reports\SimpleSheetReport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SheetExport implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{

    /**
     * @var SimpleSheetReport
     */
    private $report;

    public function __construct(SimpleSheetReport $report)
    {
        $this->report = $report;
    }

    /**
     * @inheritDoc
     */
    public function collection()
    {
        return $this->report->rows();
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return $this->report->title();
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
