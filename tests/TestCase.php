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
            'password' => 'secret'
        ]);

        $this->actingAs($manager);

        return $this;
    }
}
