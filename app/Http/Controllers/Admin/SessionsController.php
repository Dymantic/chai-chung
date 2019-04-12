<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSessionForm;
use App\Http\Requests\DeleteSessionRequest;
use App\Time\Session;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    public function index()
    {
        $user = request()->user();
        return $user()
            ->sessions()
            ->with(['client', 'engagement_code'])
            ->get()
            ->map
            ->presentFor($user);
    }

    public function store(CreateSessionForm $form)
    {
        return request()->user()->addSession($form->session_data());
    }

    public function delete(DeleteSessionRequest $request, Session $session)
    {
        $session->delete();
    }
}
