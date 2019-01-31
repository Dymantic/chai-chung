<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromoteToManagerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_non_mananger_may_be_promoted_to_manager_status()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['is_manager' => false]);

        $response = $this->asManager()->postJson("/admin/managers", ['user_id' => $user->id]);
        $response->assertStatus(200);

        $this->assertTrue($user->fresh()->is_manager);
    }

    /**
     *@test
     */
    public function the_user_id_is_required()
    {
        $response = $this->asManager()->postJson("/admin/managers", ['user_id' => null]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('user_id');
    }

    /**
     *@test
     */
    public function the_user_id_must_be_for_an_existing_user()
    {
        $response = $this->asManager()->postJson("/admin/managers", ['user_id' => 999]);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('user_id');
    }

    /**
     *@test
     */
    public function a_non_manager_cannot_promote_to_manager()
    {
        $buddy = factory(User::class)->create(['is_manager' => false]);
        $user = factory(User::class)->create(['is_manager' => false]);

        $response = $this->actingAs($buddy)->postJson("/admin/managers", ['user_id' => $user->id]);

        $response->assertStatus(403);

        $this->assertFalse($user->fresh()->is_manager);
    }
}