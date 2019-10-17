<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePeriodsController extends Controller
{
    public function index()
    {
        return [
            ['id' => 1, 'text' => 2018],
            ['id' => 2, 'text' => 2019],
            ['id' => 3, 'text' => 2020]
        ];
    }
}
