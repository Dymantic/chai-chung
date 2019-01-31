<?php


namespace Tests\Feature\Users;


use App\Notifications\WelcomeUser;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyNewUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_newly_created_user_is_notified_of_their_new_login_details()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $response = $this->asManager()->postJson("/admin/users", [
            'name'                  => 'test name',
            'email'                 => 'test@test.test',
            'is_manager'            => false,
            'password'              => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $response->assertStatus(201);
        $user = User::where(['email' => 'test@test.test'])->first();

        Notification::assertSentTo($user, WelcomeUser::class, function ($notification, $channels) {
            $correct_channel = $channels === ['mail'];
            $correct_login = $notification->login === [
                    'name'     => 'test name',
                    'email'    => 'test@test.test',
                    'password' => 'secret',
                ];

            return $correct_channel && $correct_login;
        });
    }
}