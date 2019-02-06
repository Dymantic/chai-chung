<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_registered_users_can_be_fetched()
    {
        $manager = factory(User::class)->create(['is_manager' => true]);
        $staffA = factory(User::class)->create(['is_manager' => false]);
        $staffB = factory(User::class)->create(['is_manager' => false]);

        $system_users = collect([$manager, $staffA, $staffB]);

        $response = $this->actingAs($manager)->get("/admin/users");
        $response->assertStatus(200);

        $fetched_users = collect($response->decodeResponseJson());

        $this->assertTrue($system_users->count() === $fetched_users->count());
        $system_users->each(function($user) use ($fetched_users) {
            $this->assertTrue($fetched_users->pluck('id')->contains($user->id));
        });
    }

    /**
     *@test
     */
    public function only_a_manager_can_fetch_all_users()
    {
        $manager = factory(User::class)->create(['is_manager' => true]);
        $staff = factory(User::class)->create(['is_manager' => false]);

        $response = $this->actingAs($staff)->get("/admin/users");
        $response->assertStatus(403);
    }
}