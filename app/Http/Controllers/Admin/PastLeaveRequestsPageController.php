<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PastLeaveRequestsPageController extends Controller
{
    public function show()
    {
        return view('admin.leave.past-requests.show');
    }
}
