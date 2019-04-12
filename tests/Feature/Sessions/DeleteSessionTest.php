<?php


namespace Tests\Feature\Sessions;


use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_session_may_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['is_manager' => false]);
        $session = factory(Session::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/admin/sessions/{$session->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('time_sessions', ['id' => $session->id]);
    }

    /**
     *@test
     */
    public function a_manager_can_delete_another_users_session()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['is_manager' => false]);
        $session = factory(Session::class)->create(['user_id' => $user->id]);

        $response = $this->asManager()->deleteJson("/admin/sessions/{$session->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('time_sessions', ['id' => $session->id]);
    }

    /**
     *@test
     */
    public function a_staff_member_cannot_delete_another_staff_members_session()
    {
        $userA = factory(User::class)->create(['is_manager' => false]);
        $userB = factory(User::class)->create(['is_manager' => false]);
        $session = factory(Session::class)->create(['user_id' => $userA->id]);

        $response = $this->actingAs($userB)->deleteJson("/admin/sessions/{$session->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('time_sessions', ['id' => $session->id]);
    }
}