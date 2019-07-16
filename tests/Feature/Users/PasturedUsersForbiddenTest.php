<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasturedUsersForbiddenTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function accessing_admin_is_forbidden_to_pastured_users()
    {
        $user = factory(User::class)->create(['is_manager' => true]);
        $user->safeDelete();

        $response = $this->actingAs($user)->get("/admin/dashboard");
        $response->assertStatus(403);
    }
}