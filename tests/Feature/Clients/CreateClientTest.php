<?php

namespace Tests\Feature\Clients;

use App\Clients\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_client_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->asManager()->postJson("/admin/clients", [
            'name'           => 'Test client',
            'client_code'           => 'test_code',
            'annual_revenue' => 1000000
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('clients', [
            'name'           => 'Test client',
            'client_code'           => 'test_code',
            'annual_revenue' => 1000000
        ]);
    }

    /**
     *@test
     */
    public function a_client_can_only_be_created_by_a_manager()
    {
        $response = $this->asStaff()->postJson("/admin/clients", [
            'name'           => 'Test client',
            'client_code'           => 'test_code',
            'annual_revenue' => 1000000
        ]);
        $response->assertStatus(403);
        $this->assertCount(0, Client::all());
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['name' => '']);
    }

    /**
     *@test
     */
    public function the_client_code_is_required()
    {
        $this->assertFieldIsInvalid(['client_code' => '']);
    }

    /**
     *@test
     */
    public function the_client_code_must_be_unique()
    {
        factory(Client::class)->create(['client_code' => 'used-code']);

        $this->assertFieldIsInvalid(['client_code' => 'used-code']);
    }

    /**
     *@test
     */
    public function the_annual_revenue_is_required()
    {
        $this->assertFieldIsInvalid(['annual_revenue' => null]);
    }

    /**
     *@test
     */
    public function the_annual_revenue_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['annual_revenue' => 'not-an-integer']);
    }

    private function assertFieldIsInvalid($invalid)
    {
        $valid = [
            'name'                  => 'Test client',
            'client_code'             => 'test_user_code',
            'annual_revenue'           => 500,
        ];

        $response = $this->asManager()->postJson('/admin/clients', array_merge($valid, $invalid));
        $response->assertStatus(422);


        $response->assertJsonValidationErrors(array_keys($invalid)[0]);

    }
}