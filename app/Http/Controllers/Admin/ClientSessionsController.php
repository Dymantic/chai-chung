<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientSessionsController extends Controller
{
    public function index(Client $client)
    {
        return $client->sessions()->latest()->limit(50)->get()->map->presentFor(request()->user());
    }
}
