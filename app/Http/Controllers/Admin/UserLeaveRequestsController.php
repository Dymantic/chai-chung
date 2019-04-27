<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLeaveRequestForm;
use App\Leave\LeaveRequest;
use App\Notifications\RequestForCover;
use App\Rules\BusinessHours;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserLeaveRequestsController extends Controller
{

    public function index()
    {
        return request()->user()->leaveRequests->map->toArray();
    }


    public function store(UserLeaveRequestForm $form)
    {
        $leave_request = request()->user()->createLeaveRequest($form->parsedInput());

        $leave_request->covered_by->notify(new RequestForCover($leave_request->toArray()));

        return $leave_request;
    }

    public function update(LeaveRequest $leaveRequest)
    {
        request()->validate([
            'covering_user_id' => ['required', 'exists:users,id']
        ]);

        if(!$leaveRequest->user->is(request()->user())) {
            abort(403);
        }

        $coverer = User::find(request('covering_user_id'));
        $leaveRequest->updateCoveringUser($coverer);
        $leaveRequest = $leaveRequest->fresh();

        $leaveRequest->covered_by->notify(new RequestForCover($leaveRequest->toArray()));
    }
}
