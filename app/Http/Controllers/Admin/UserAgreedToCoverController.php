<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAgreedToCoverController extends Controller
{
    public function index()
    {
        return request()->user()->agreedToCover()->map->toArray();
    }
}
