<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_user_can_login()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['email' => 'test@test.test']); //password is 'secret'
        $this->assertFalse(Auth::check());

        $response = $this->post("/admin/login", ['email' => 'test@test.test', 'password' => 'secret']);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/dashboard');

        $this->assertTrue(Auth::check());
    }

    /**
     *@test
     */
    public function a_guest_cannot_login_with_incorrect_credentials()
    {
        $this->assertFalse(Auth::check());

        $response = $this->post("/admin/login", ['email' => 'test@test.test', 'password' => 'wild-guess']);
        $response->assertStatus(302);

        $this->assertFalse(Auth::check());
    }
}