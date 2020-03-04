<?php


namespace App\Reports;


interface SimpleSheetReport
{
    public function rows();

    public function title();

    public function headings();

    public function date_range_string();
}
