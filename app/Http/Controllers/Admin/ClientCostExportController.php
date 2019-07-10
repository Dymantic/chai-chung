<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SimpleReportExport;
use App\Reports\ClientCostReport;
use App\Reports\ClientTimeCostReport;
use App\Reports\StaffTimeCostReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ClientCostExportController extends Controller
{
    public function show(ClientCostReport $report)
    {
        $report = new ClientTimeCostReport($report);

        $export = new SimpleReportExport($report);

        return Excel::download($export, "{$report->slug()}.xlsx");
    }
}
