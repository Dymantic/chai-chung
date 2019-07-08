<?php

namespace App\Http\Controllers\Admin;

use App\Reports\StaffCostReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerReportsController extends Controller
{
    public function staffTime()
    {
        return view('admin.reports.staff-time.index');
    }

    public function clientTime()
    {
        return view('admin.reports.client-time.index');
    }

    public function engagementTime()
    {
        return view('admin.reports.engagement-time.index');
    }


}
