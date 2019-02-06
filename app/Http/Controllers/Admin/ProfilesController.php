<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfilesController extends Controller
{
    public function show()
    {
        return view('admin.users.profile', ['user' => request()->user()]);
    }
}
