<?php


namespace App\Reports;


interface SimpleReport
{
    public function slug();

    public function rows();

    public function headings();

    public function date_range_string();

    public function title();
}