<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Client;
use App\Clients\EngagementCode;
use App\Http\Requests\CreateSessionForm;
use App\Rules\StartEndTime;
use App\Time\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    public function index()
    {
        return request()->user()->sessions()->with(['client', 'engagement_code'])->get();
    }

    public function store(CreateSessionForm $form)
    {
        return request()->user()->addSession($form->session_data());
    }
}
