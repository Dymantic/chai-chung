<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_users_name_and_email_may_be_updated()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'name' => 'Old name',
            'email' => 'old@test.test'
        ]);

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}", [
            'name' => 'New name',
            'email' => 'new@test.test'
        ]);
        $response->assertStatus(200);

        $this->assertEquals('New name', $response->decodeResponseJson("name"));
        $this->assertEquals('new@test.test', $response->decodeResponseJson("email"));

        $this->assertEquals('New name', $user->fresh()->name);
        $this->assertEquals('new@test.test', $user->fresh()->email);
    }

    /**
     *@test
     */
    public function the_name_may_be_updated_and_email_left_the_same()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'name' => 'Old name',
            'email' => 'old@test.test'
        ]);

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}", [
            'name' => 'New name',
            'email' => 'old@test.test'
        ]);
        $response->assertStatus(200);

        $this->assertEquals('New name', $user->fresh()->name);
        $this->assertEquals('old@test.test', $user->fresh()->email);
    }

    /**
     *@test
     */
    public function a_non_manager_may_not_update_their_is_manager_status()
    {
        $user = factory(User::class)->create([
            'name' => 'Old name',
            'email' => 'old@test.test',
            'is_manager' => false
        ]);

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}", [
            'name' => 'New name',
            'email' => 'old@test.test',
            'is_manager' => true
        ]);
        $response->assertStatus(403);
    }

    /**
     *@test
     */
    public function the_name_field_is_required()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     *@test
     */
    public function the_email_field_is_required()
    {
        $this->assertFieldIsInvalid(['email' => null]);
    }

    /**
     *@test
     */
    public function the_email_must_be_unique()
    {
        User::create([
            'name' => 'existing',
            'email' => 'existing@test.test',
            'is_manager' => true,
            'password' => 'secret'
        ]);

        $this->assertFieldIsInvalid(['email' => 'existing@test.test']);
    }

    private function assertFieldIsInvalid($invalid)
    {

        $valid = [
            'name'                  => 'New name',
            'email'                 => 'new@test.test',
        ];

        $user = factory(User::class)->create([
            'name' => 'Old name',
            'email' => 'old@test.test'
        ]);

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}", array_merge($valid, $invalid));
        $response->assertStatus(422);


        $response->assertJsonValidationErrors(array_keys($invalid)[0]);

    }
}