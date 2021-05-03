<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicePeriodsController extends Controller
{
    public function index()
    {

        return collect(range(2018, now()->year))
            ->map(fn ($year, $index) => ['id' => $index + 1, 'text' => $year])
            ->all();
    }
}
