<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use App\Notifications\CoverRequestCancelled;
use App\Notifications\LeaveRequestDenied;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeniedLeaveRequestsController extends Controller
{

    public function store()
    {
        $leave_request = LeaveRequest::findOrFail(request('leave_request_id'));

        $leave_request->denyBy(request()->user());

        $leave_request->user->notify(new LeaveRequestDenied($leave_request->fresh()->toArray()));
        $leave_request->covered_by->notify(new CoverRequestCancelled($leave_request->fresh()->toArray()));
    }
}
