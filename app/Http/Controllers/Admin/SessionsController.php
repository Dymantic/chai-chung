<?php

namespace App\Http\Controllers\Admin;

use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    public function store()
    {
        return request()->user()->addSession(request()->all());
    }
}
