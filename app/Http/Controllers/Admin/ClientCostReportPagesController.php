<?php

namespace App\Http\Controllers\Admin;

use App\Reports\ClientCostReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientCostReportPagesController extends Controller
{
    public function index()
    {
        $reports = ClientCostReport::with('entries', 'entries.client')->latest()->get()->map->toArray();

        return view('admin.reports.client-cost.index', ['reports' => $reports]);
    }

    public function show(ClientCostReport $report)
    {
        $report->load(['entries', 'entries.client']);
        return view('admin.reports.client-cost.show', ['report' => $report->toArray()]);
    }
}
