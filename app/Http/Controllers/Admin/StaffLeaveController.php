<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffLeaveController extends Controller
{
    public function index()
    {
        $users = User::all()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name
            ];
        });
        return view('admin.leave.index', ['users' => $users]);
    }
}
