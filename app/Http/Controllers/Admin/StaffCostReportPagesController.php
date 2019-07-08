<?php

namespace App\Http\Controllers\Admin;

use App\Reports\StaffCostReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffCostReportPagesController extends Controller
{
    public function index()
    {
        $reports = StaffCostReport::with(['entries', 'entries.user'])->latest()->get()->map->toArray();
        return view('admin.reports.staff-cost.index', ['reports' => $reports]);
    }

    public function show(StaffCostReport $report)
    {
        $report->load(['entries', 'entries.user']);
        return view('admin.reports.staff-cost.show', ['report' => $report->toArray()]);
    }
}
