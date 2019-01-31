<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagersController extends Controller
{
    public function store()
    {
        request()->validate(['user_id' => ['required', 'exists:users,id']]);
        $user = User::findOrFail(request('user_id'));

        $user->promote();
    }

    public function delete(User $user)
    {
        $user->demote();
    }
}
