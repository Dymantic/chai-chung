<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StaffTimeReportExport;
use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StaffTimeExportController extends Controller
{
    public function show()
    {
        $from = Carbon::parse(request('from'));
        $to = Carbon::parse(request('to'));

        $export = new StaffTimeReportExport([
            'from' => $from,
            'to' => $to
        ]);

        return Excel::download($export, 'testexport.xlsx');
    }
}
