<?php


namespace Tests\Unit\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasturedUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function safe_delete_pastures_a_user()
    {
        $user = factory(User::class)->create();
        $this->assertNull($user->pastured_on);

        $user->safeDelete();
        $user = $user->fresh();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertTrue($user->pastured_on->isToday());
        $this->assertTrue($user->isPastured());
    }

    /**
     *@test
     */
    public function active_scope()
    {
        $activeA = factory(User::class)->create();
        $activeB = factory(User::class)->create();
        $gone = factory(User::class)->create();
        $gone->safeDelete();

        $users = User::active()->get();

        $this->assertCount(2, $users);

        $this->assertTrue($users->contains(function($u) use ($activeA) {
            return $u->id === $activeA->id;
        }));

        $this->assertTrue($users->contains(function($u) use ($activeB) {
            return $u->id === $activeB->id;
        }));

        $this->assertFalse($users->contains(function($u) use ($gone) {
            return $u->id === $gone->id;
        }));
    }
}