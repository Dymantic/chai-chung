<?php

namespace App\Http\Controllers\Admin;

use App\Time\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class HolidaysController extends Controller
{

    public function index()
    {
        return Holiday::all();
    }

    public function store()
    {
        request()->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date']
        ]);
        return Holiday::setDates([
            'start' => Carbon::parse(request('start_date')),
            'end' => Carbon::parse(request('end_date')),
            'name' => request('name')
        ]);
    }

    public function delete(Holiday $holiday)
    {
        $holiday->delete();
    }
}
