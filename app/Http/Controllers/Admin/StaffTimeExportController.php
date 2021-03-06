<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Http\Requests\DatedQueryRequest;
use App\Reports\StaffTimeReport;
use App\Time\DateRange;
use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StaffTimeExportController extends Controller
{
    public function show(DatedQueryRequest $request)
    {
        $report = new StaffTimeReport($request->dateRange());

        $export = new SimpleReportExport($report);

        return Excel::download($export, "{$report->slug()}.xlsx");
    }
}
