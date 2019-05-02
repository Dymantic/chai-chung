<?php

namespace App\Http\Controllers\Admin;

use App\Reports\StaffTimeReport;
use App\Time\DateRange;
use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class StaffTimeReportController extends Controller
{
    public function show()
    {
        $date_range = new DateRange(Carbon::parse(request('from')), Carbon::parse(request('to')));
        $report = new StaffTimeReport($date_range);

        return [
            'headings' => $report->headings(),
            'rows' => $report->rows()
        ];
    }
}
