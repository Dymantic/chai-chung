<?php

namespace App\Http\Controllers\Admin;

use App\Rules\CurrentPassword;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPasswordController extends Controller
{
    public function update(User $user)
    {
        $this->ensureIsSelf($user);

        request()->validate([
            'current_password' => [new CurrentPassword($user)],
            'password' => ['confirmed', 'min:6']
        ]);

        $user->setPassword(request('password'));
    }

    private function ensureIsSelf($user)
    {
        if(request()->user()->id !== $user->id) {
            abort(403);
        }
    }
}
