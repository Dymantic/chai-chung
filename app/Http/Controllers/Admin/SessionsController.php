<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateSessionForm;
use App\Http\Requests\DeleteSessionRequest;
use App\Time\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class SessionsController extends Controller
{
    public function index()
    {
        $user = request()->user();

        return Session::matching([
            'from'      => request()->get("from", Carbon::today()->subDays(14)->format('Y-m-d')),
            'to'        => request()->get("to", Carbon::today()->format('Y-m-d')),
            'client_id' => request()->get('client_id'),
            'user_id'   => $user->id,
        ])
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
