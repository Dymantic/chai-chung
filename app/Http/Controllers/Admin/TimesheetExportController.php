<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MultisheetExport;
use App\Exports\SimpleReportExport;
use App\Http\Controllers\Controller;
use App\Reports\TimesheetReport;
use App\Reports\TimeSummaryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetExportController extends Controller
{
    public function show()
    {
        $start = request('start', Carbon::today()->subDays(14));
        $end = request('end', Carbon::today());
        $user = request('user_id');
        $client = request('client_id');

        $report = new TimeSummaryReport(Carbon::parse($start), Carbon::parse($end));
        $export = new MultisheetExport($report);

        return Excel::download($export, $export->exportName());
    }
}
