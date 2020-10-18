<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserRateTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_users_rate_may_be_updated()
    {
        $this->withoutExceptionHandling();
        $staff = factory(User::class)->create(['hourly_rate' => 500]);

        $response = $this->asManager()->postJson("/admin/users/{$staff->id}/rate", ['hourly_rate' => 600]);
        $response->assertStatus(200);
        $this->assertEquals(600, $response->json('hourly_rate'));

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'hourly_rate' => 600
        ]);

    }

    /**
     *@test
     */
    public function a_users__rate_can_only_be_updated_by_a_manager()
    {
        $staff = factory(User::class)->create(['hourly_rate' => 500]);

        $response = $this->asStaff()->postJson("/admin/users/{$staff->id}/rate", ['hourly_rate' => 600]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'hourly_rate' => 500
        ]);
    }

    /**
     *@test
     */
    public function the_hourly_rate_is_required()
    {
        $staff = factory(User::class)->create(['hourly_rate' => 500]);

        $response = $this->asManager()->postJson("/admin/users/{$staff->id}/rate", ['hourly_rate' => null]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('hourly_rate');

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'hourly_rate' => 500
        ]);
    }

    /**
     *@test
     */
    public function the_hourly_rate_must_be_an_integer()
    {
        $staff = factory(User::class)->create(['hourly_rate' => 500]);

        $response = $this->asManager()->postJson("/admin/users/{$staff->id}/rate", ['hourly_rate' => 'not-an-integer']);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('hourly_rate');

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'hourly_rate' => 500
        ]);
    }


}
