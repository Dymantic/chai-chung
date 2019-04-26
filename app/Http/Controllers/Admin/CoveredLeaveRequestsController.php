<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use App\Notifications\CoverWasAccepted;
use App\Notifications\RequestForLeave;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoveredLeaveRequestsController extends Controller
{
    public function store()
    {
        $leave_request = LeaveRequest::findOrFail(request('leave_request_id'));

        if(!request()->user()->is($leave_request->covered_by)) {
            abort(403);
        }

        $leave_request->cover();

        User::managers()->get()->each(function($manager) use ($leave_request) {
            $manager->notify(new RequestForLeave($leave_request->fresh()->toArray()));
        });

        $leave_request->user->notify(new CoverWasAccepted($leave_request->fresh()->toArray()));
    }
}
