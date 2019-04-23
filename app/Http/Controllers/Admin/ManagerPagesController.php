<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Client;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerPagesController extends Controller
{
    public function users()
    {
        return view('admin.users.index');
    }

    public function clients()
    {
        return view('admin.clients.index');
    }

    public function engagementCodes()
    {
        return view('admin.engagement-codes.index');
    }

    public function holidays()
    {
        return view('admin.holidays.index');
    }

    public function sessions()
    {
        $clients = Client::all();
        $staff = User::all();
        return view('admin.all-sessions.index', ['clients' => $clients, 'staff' => $staff]);
    }
}
