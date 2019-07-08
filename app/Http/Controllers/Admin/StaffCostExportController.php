<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Reports\StaffCostReport;
use App\Reports\StaffTimeCostReport;
use App\Reports\StaffTimeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class StaffCostExportController extends Controller
{
    public function show(StaffCostReport $report)
    {
        $report = new StaffTimeCostReport($report);

        $export = new SimpleReportExport($report);

        return Excel::download($export, "{$report->slug()}.xlsx");
    }
}
