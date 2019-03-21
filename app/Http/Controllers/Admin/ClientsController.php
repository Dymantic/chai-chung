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

    public function update(Client $client)
    {
        request()->validate([
            'name' => ['required'],
            'annual_revenue' => ['required', 'integer']
        ]);

        $client->update(request()->only('name', 'annual_revenue'));

        return $client->fresh();
    }
}
