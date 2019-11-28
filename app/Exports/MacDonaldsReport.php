<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MacDonaldsReport implements FromView, ShouldAutoSize, WithEvents
{

    private $date;
    private $franchises;

    public function __construct($data)
    {
        $this->date = $data['date'];
        $this->franchises = $data['reports'];
    }

    public function view(): View
    {
        return view('admin.reports.macdonalds.index', [
            'date'       => $this->date,
            'franchises' => $this->franchises,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->makeRanges()->each(function ($range) use ($event) {
                    $range->each(function ($block) use ($event) {
                        $event->sheet->getDelegate()->getStyle($block[0])->getFill()
                                     ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB("ff{$block[1]}");
                    });
                });
            }
        ];
    }

    private function makeRanges()
    {
        return collect($this->franchises)
            ->map(function ($report, $index) {
                return collect($this->baseColourRanges())
                    ->map(function ($block) use ($index) {
                        $start = $block['range'][0] + (285 * $index);
                        $end = $block['range'][1] + (285 * $index);

                        return ["C{$start}:F{$end}", $block['colour']];
                    });
            });
    }

    private function baseColourRanges()
    {
        return [
            ['range' => [41, 45], 'colour' => 'e4b8b6'],
            ['range' => [46, 53], 'colour' => 'c1d59b'],
            ['range' => [54, 58], 'colour' => 'fad3b3'],
            ['range' => [59, 69], 'colour' => 'e4b8b6'],
            ['range' => [70, 124], 'colour' => 'fdfd00'],
            ['range' => [125, 286], 'colour' => 'b6dde7'],
        ];
    }
}
