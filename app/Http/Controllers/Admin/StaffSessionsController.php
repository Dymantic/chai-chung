<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Time\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StaffSessionsController extends Controller
{
    public function index()
    {

        return Session::matching([
            'from'      => request()->get("from", Carbon::today()->subDays(14)->format('Y-m-d')),
            'to'        => request()->get("to", Carbon::today()->format('Y-m-d')),
            'client_id' => request()->get('client_id'),
            'user_id'   => request()->get('user_id'),
        ])
            ->map
            ->presentFor(request()->user());
    }
}
