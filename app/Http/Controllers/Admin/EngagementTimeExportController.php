<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Http\Requests\DatedQueryRequest;
use App\Reports\EngagementTimeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class EngagementTimeExportController extends Controller
{
    public function show(DatedQueryRequest $request)
    {
        $report = new EngagementTimeReport($request->dateRange());

        $export = new SimpleReportExport($report);

        return Excel::download($export, "{$report->slug()}.xlsx");
    }
}
