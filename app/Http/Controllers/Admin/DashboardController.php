<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Client;
use App\Clients\EngagementCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        $periods = [
            ['id' => 1, 'text' => 2018],
            ['id' => 2, 'text' => 2019],
            ['id' => 3, 'text' => 2020]
        ];
        return view('admin.sessions.index', [
            'clients' => Client::active()->get(),
            'engagement_codes' => EngagementCode::active()->get(),
            'service_periods' => $periods
        ]);
    }
}
