<?php

namespace App\Http\Controllers\Admin;

use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionOvertimeController extends Controller
{
    public function update(Session $session)
    {
        request()->validate([
            'minutes' => ['required', 'integer', 'min:0'],
            'reason' => ['required']
        ]);

        $session->overtime_set_by = request()->user()->id;
        $session->manual_overtime = request('minutes');
        $session->manual_overtime_reason = request('reason');
        $session->save();
    }
}
