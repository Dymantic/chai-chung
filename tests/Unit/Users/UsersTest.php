<?php

namespace Tests\Unit\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_user_may_be_promoted_to_manager()
    {
        $user = factory(User::class)->create(['is_manager' => false]);
        $this->assertFalse($user->fresh()->is_manager);

        $user->promote();

        $this->assertTrue($user->fresh()->is_manager);
    }

    /**
     *@test
     */
    public function a_manager_can_be_demoted()
    {
        $user = factory(User::class)->create(['is_manager' => true]);
        $this->assertTrue($user->fresh()->is_manager);

        $user->demote();

        $this->assertFalse($user->fresh()->is_manager);
    }

    /**
     *@test
     */
    public function a_users_password_can_be_updated()
    {
        $user = factory(User::class)->create(['password' => 'secret']);

        $user->setPassword('top_secret');

        $this->assertTrue(
            Hash::check('top_secret', $user->fresh()->password),
            'password should match top_secret'
        );
    }
}