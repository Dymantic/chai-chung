<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class PastLeaveRequestsController extends Controller
{
    public function index()
    {
        $year = request('year', Carbon::now()->year);
        $start = Carbon::create($year, 1, 1, 0, 0);
        $end = Carbon::create($year, 12, 31, 23, 59);

        $requests = LeaveRequest::where('starts', '<=',  Carbon::today()->endOfDay())->whereBetween('starts', [$start, $end])->get();

        return $requests->groupBy(function($lr) {
            return $lr->starts->format('F');
        });
    }
}
