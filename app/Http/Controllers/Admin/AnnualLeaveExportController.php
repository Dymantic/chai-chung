<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Reports\AnnualLeaveReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AnnualLeaveExportController extends Controller
{
    public function show()
    {
        request()->validate([
            'year' => ['required', 'integer']
        ]);

        $report = new AnnualLeaveReport(request('year'));
        $export = new SimpleReportExport($report);

        return Excel::download($export, $report->slug() . ".xlsx");
    }
}
