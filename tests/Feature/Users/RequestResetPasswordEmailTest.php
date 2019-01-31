<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RequestResetPasswordEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_user_may_request_to_reset_their_password()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $user = factory(User::class)->create(['email' => 'test@test.com']);

        $response = $this->post("/admin/password/reset", ['email' => 'test@test.com']);
        $response->assertStatus(302);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}