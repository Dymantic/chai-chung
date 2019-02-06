<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\WelcomeUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

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

        $user->notify(new WelcomeUser(request()->only('name', 'email', 'password')));

        return $user;
    }

    public function update(User $user)
    {
        if(!$user->is_manager && request()->has('is_manager')) {
            abort(403);
        }
        $data = request()->validate([
            'name' => ['required'],
            'email' => ['required', Rule::unique('users')->ignore($user->id),]
        ]);
        $user->update($data);

        return $user->fresh();
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
