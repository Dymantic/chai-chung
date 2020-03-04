<?php


namespace App\Reports;


interface MultisheetReport
{
    public function sheets();

    public function slug();
}
