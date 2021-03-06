<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserForm;
use App\Notifications\WelcomeUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        return User::active()->get();
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function store(CreateUserForm $form)
    {

        $user = User::create($form->userAttributes());

        $user->notify(new WelcomeUser($form->only('name', 'email', 'password')));

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
        $this->flashSuccess(['message' => $user->name .' has been deleted!']);
        $user->safeDelete();
    }
}
