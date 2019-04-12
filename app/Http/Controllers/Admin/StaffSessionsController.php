<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Time\Session;
use Illuminate\Http\Request;

class StaffSessionsController extends Controller
{
    public function index()
    {
        return Session::with(['client', 'engagement_code'])
            ->get()
            ->map
            ->presentFor(request()->user());
    }
}
