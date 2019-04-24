<?php

namespace App\Http\Controllers\Admin;

use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class EngagementTimeReportController extends Controller
{
    public function show()
    {
        $from = Carbon::parse(request('from'));
        $to = Carbon::parse(request('to'));

        return Session::engagementTimeReport([
            'from' => $from,
            'to' => $to
        ]);
    }
}
