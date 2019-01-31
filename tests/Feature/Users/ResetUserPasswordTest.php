<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_user_may_reset_their_current_password()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(); //password is 'secret'

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}/password", [
            'current_password' => 'secret',
            'password' => 'top_secret',
            'password_confirmation' => 'top_secret',
        ]);
        $response->assertStatus(200);

        $this->assertTrue(
            Hash::check('top_secret', $user->fresh()->password),
            'the new password should match top_secret'
        );
    }

    /**
     *@test
     */
    public function a_user_cannot_reset_another_users_password()
    {
        $user = factory(User::class)->create(); //password is 'secret'
        $bad_actor = factory(User::class)->create(['is_manager' => true]);

        $response = $this->actingAs($bad_actor)->postJson("/admin/users/{$user->id}/password", [
            'current_password' => 'secret',
            'password' => 'top_secret',
            'password_confirmation' => 'top_secret',
        ]);

        $response->assertStatus(403);

        $this->assertTrue(
            Hash::check('secret', $user->fresh()->password),
            'the new password should match secret'
        );
    }

    /**
     *@test
     */
    public function the_current_password_must_be_correct()
    {
        $user = factory(User::class)->create(); //password is 'secret'

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}/password", [
            'current_password' => 'not_correct',
            'password' => 'top_secret',
            'password_confirmation' => 'top_secret',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('current_password');
    }

    /**
     *@test
     */
    public function the_password_must_be_confirmed()
    {
        $user = factory(User::class)->create(); //password is 'secret'

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}/password", [
            'current_password' => 'secret',
            'password' => 'top_secret',
            'password_confirmation' => 'not confirmed',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    /**
     *@test
     */
    public function the_new_password_must_be_six_characters_or_more()
    {
        $user = factory(User::class)->create(); //password is 'secret'

        $response = $this->actingAs($user)->postJson("/admin/users/{$user->id}/password", [
            'current_password' => 'secret',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }
}