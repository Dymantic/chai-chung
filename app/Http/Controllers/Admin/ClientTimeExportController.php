<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Http\Requests\DatedQueryRequest;
use App\Reports\ClientTimeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ClientTimeExportController extends Controller
{
    public function show(DatedQueryRequest $request)
    {
        $report = new ClientTimeReport($request->dateRange());

        $export = new SimpleReportExport($report);

        return Excel::download($export, "{$report->slug()}.xlsx");
    }
}
