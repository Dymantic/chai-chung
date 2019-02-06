<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerPagesController extends Controller
{
    public function users()
    {
        return view('admin.users.index');
    }
}
