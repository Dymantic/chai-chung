<?php


namespace Tests\Feature\Sessions;


use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSessionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_users_sessions_may_be_fetched()
    {
        $this->withoutExceptionHandling();

        $staff = factory(User::class)->create(['is_manager' => false]);
        $sessions = factory(Session::class, 10)->create(['user_id' => $staff->id]);

        $response = $this->actingAs($staff)->getJson("/admin/sessions");
        $response->assertStatus(200);

        $fetched_sessions = $response->json();
        $this->assertEquals($sessions->map->toArray()->all(), $fetched_sessions);
    }
}
