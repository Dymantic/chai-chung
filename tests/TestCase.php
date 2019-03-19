<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asManager()
    {
        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@test.test',
            'is_manager' => true,
            'password' => 'secret',
            'user_code' => 'testcode',
            'hourly_rate' => 600
        ]);

        $this->actingAs($manager);

        return $this;
    }

    public function asStaff()
    {
        $staff = User::create([
            'name' => 'staff',
            'email' => 'staff@test.test',
            'is_manager' => false,
            'password' => 'secret',
            'user_code' => 'test_staff_code',
            'hourly_rate' => 300
        ]);

        $this->actingAs($staff);

        return $this;
    }
}
