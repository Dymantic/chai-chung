<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use App\Notifications\CoverWasRejected;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoverRejectedLeaveRequestsController extends Controller
{

    public function store()
    {
        $leave_request = LeaveRequest::findOrFail(request('leave_request_id'));

        if(!request()->user()->is($leave_request->covered_by)) {
            abort(403);
        }

        $leave_request->rejectCover();

        $leave_request->user->notify(new CoverWasRejected($leave_request->fresh()->toArray()));
    }
}
