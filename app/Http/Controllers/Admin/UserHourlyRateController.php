<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserHourlyRateController extends Controller
{
    public function update(User $user)
    {
        request()->validate([
            'hourly_rate' => ['required', 'integer']
        ]);

        $user->hourly_rate = request('hourly_rate');
        $user->save();
        return $user->fresh();
    }
}
