<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['confirmed', 'min:6']
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'is_manager' => request('is_manager'),
            'password' => bcrypt(request('password')),
        ]);

        return $user;
    }
}
