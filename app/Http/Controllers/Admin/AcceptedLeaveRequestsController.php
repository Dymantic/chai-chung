<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use App\Notifications\LeaveRequestAccepted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcceptedLeaveRequestsController extends Controller
{

    public function store()
    {
        $leave_request = LeaveRequest::findOrFail(request('leave_request_id'));

        $leave_request->acceptBy(request()->user());

        $leave_request->user->notify(new LeaveRequestAccepted($leave_request->fresh()->toArray()));
    }
}
