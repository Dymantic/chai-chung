<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->asManager()->deleteJson("/admin/users/{$user->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}