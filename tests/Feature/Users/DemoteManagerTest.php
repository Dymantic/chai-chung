<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoteManagerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_manager_may_be_demoted_to_a_regular_user()
    {
        $this->withoutExceptionHandling();
        $bad_manager = factory(User::class)->create(['is_manager' => true]);

        $response = $this->asManager()->deleteJson("/admin/managers/{$bad_manager->id}");
        $response->assertStatus(200);

        $this->assertFalse($bad_manager->fresh()->is_manager);
    }

    /**
     *@test
     */
    public function a_non_manager_may_not_demote_someone()
    {
        $staff_user = factory(User::class)->create(['is_manager' => false]);
        $petty_enemy = factory(User::class)->create(['is_manager' => true]);

        $response = $this->actingAs($staff_user)->deleteJson("/admin/managers/{$petty_enemy->id}");
        $response->assertStatus(403);

        $this->assertTrue($petty_enemy->fresh()->is_manager);
    }
}