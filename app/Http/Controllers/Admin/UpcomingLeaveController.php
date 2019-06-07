<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpcomingLeaveController extends Controller
{
    public function index()
    {
        return LeaveRequest::upcomingGranted()->get()->map->toArray();
    }
}
