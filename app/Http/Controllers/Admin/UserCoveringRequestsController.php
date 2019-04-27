<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCoveringRequestsController extends Controller
{
    public function index()
    {
        return LeaveRequest::needsCoverBy(request()->user())->get();
    }
}
