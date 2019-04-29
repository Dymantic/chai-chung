<?php

namespace App\Http\Controllers\Admin;

use App\Leave\LeaveRequest;
use App\Notifications\LeaveRequestCancelled;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CancelledLeaveRequestsController extends Controller
{

    public function store()
    {
        $leave_request = LeaveRequest::findOrFail(request('leave_request_id'));
        $initial_status = $leave_request->status;

        if(!$leave_request->user->is(request()->user())) {
            return abort(403);
        }

        $leave_request->cancel();
        $leave_request_data = $leave_request->fresh()->toArray();

        if($initial_status === LeaveRequest::COVERED) {
            User::managers()->get()->each(function($manager) use ($leave_request_data) {
                $manager->notify(new LeaveRequestCancelled($leave_request_data));
            });
        }

        $leave_request->covered_by->notify(new LeaveRequestCancelled($leave_request_data));


    }
}
