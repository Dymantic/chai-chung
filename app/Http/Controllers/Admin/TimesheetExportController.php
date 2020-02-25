<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Http\Controllers\Controller;
use App\Reports\TimesheetReport;
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

        $report = new TimesheetReport(Carbon::parse($start), Carbon::parse($end), $user, $client);
        $export = new SimpleReportExport($report);

        return Excel::download($export, $report->slug() . '.xlsx');
    }
}
