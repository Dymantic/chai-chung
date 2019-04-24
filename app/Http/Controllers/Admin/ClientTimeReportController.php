<?php

namespace App\Http\Controllers\Admin;

use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ClientTimeReportController extends Controller
{
    public function show()
    {
        $from = Carbon::parse(request('from'));
        $to = Carbon::parse(request('to'));

        return Session::clientTimeReport([
            'from' => $from,
            'to' => $to
        ]);
    }
}
