<?php

namespace Tests\Feature\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_may_be_created()
    {
        $this->withoutExceptionHandling();
        $user_data = [
            'name'                  => 'Test Name',
            'email'                 => 'test@test.test',
            'user_code'             => 'abc123',
            'hourly_rate'           => 600,
            'is_manager'            => true,
            'password'              => 'secret',
            'password_confirmation' => 'secret'
        ];

        $response = $this->asManager()->postJson('/admin/users', $user_data);
        $response->assertStatus(201);

        $user = User::where(['email' => 'test@test.test'])->first();

        $this->assertDatabaseHas('users', [
            'name'        => 'Test Name',
            'email'       => 'test@test.test',
            'user_code'   => 'abc123',
            'hourly_rate' => 600,
            'is_manager'  => true,
        ]);

        $this->assertTrue(
            Hash::check('secret', $user->password),
            'password should be correctly hashed'
        );
    }

    /**
     * @test
     */
    public function a_user_can_only_be_created_by_a_manager()
    {
        $user_data = [
            'name'                  => 'Test Name',
            'email'                 => 'test@test.test',
            'is_manager'            => true,
            'password'              => 'secret',
            'password_confirmation' => 'secret'
        ];

        $response = $this->postJson('/admin/users', $user_data);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function the_name_field_is_required()
    {
        $this->assertFieldIsInvalid(['name' => null]);
    }

    /**
     * @test
     */
    public function the_email_is_required()
    {
        $this->assertFieldIsInvalid(['email' => null]);
    }

    /**
     * @test
     */
    public function the_email_must_be_a_valid_address()
    {
        $this->assertFieldIsInvalid(['email' => 'not_a_valid_email']);
    }

    /**
     * @test
     */
    public function the_user_code_is_required()
    {
        $this->assertFieldIsInvalid(['user_code' => '']);
    }

    /**
     * @test
     */
    public function a_user_code_must_be_unique()
    {
        User::create([
            'name'        => 'existing',
            'email'       => 'existing@test.test',
            'user_code'   => 'existing_test_user_code',
            'hourly_rate' => 500,
            'is_manager'  => true,
            'password'    => 'secret'
        ]);

        $this->assertFieldIsInvalid(['user_code' => 'existing_test_user_code']);
    }

    /**
     *@test
     */
    public function the_hourly_rate_is_required()
    {
        $this->assertFieldIsInvalid(['hourly_rate' => '']);
    }

    /**
     *@test
     */
    public function the_hourly_rate_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['hourly_rate' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_email_must_be_unique()
    {
        User::create([
            'name'        => 'existing',
            'email'       => 'existing@test.test',
            'user_code'   => 'existing_test_user_code',
            'hourly_rate' => 500,
            'is_manager'  => true,
            'password'    => 'secret'
        ]);

        $this->assertFieldIsInvalid(['email' => 'existing@test.test']);
    }

    /**
     * @test
     */
    public function the_password_is_required()
    {
        $this->assertFieldIsInvalid([
            'password'              => '',
            'password_confirmation' => ''
        ]);
    }

    /**
     * @test
     */
    public function the_password_must_be_confirmed()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'secret',
            'password_confirmation' => 'not matching'
        ]);
    }

    /**
     * @test
     */
    public function the_password_must_be_over_six_characters()
    {
        $this->assertFieldIsInvalid([
            'password'              => 'short',
            'password_confirmation' => 'short'
        ]);
    }

    private function assertFieldIsInvalid($invalid)
    {
        $valid = [
            'name'                  => 'Test name',
            'email'                 => 'test@test.test',
            'user_code'             => 'test_user_code',
            'hourly_rate'           => 500,
            'is_manager'            => true,
            'password'              => 'secret',
            'password_confirmation' => 'secret'
        ];

        $response = $this->asManager()->postJson('/admin/users', array_merge($valid, $invalid));
        $response->assertStatus(422);


        $response->assertJsonValidationErrors(array_keys($invalid)[0]);

    }
}