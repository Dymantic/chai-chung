<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'client_code' => ['required', 'unique:clients,client_code'],
            'annual_revenue' => ['required', 'integer']
        ]);
        $client = Client::create(request()->all());

        return $client;
    }
}
