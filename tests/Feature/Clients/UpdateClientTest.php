<?php


namespace Tests\Feature\Clients;


use App\Clients\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_client_name_and_annual_revenue_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $client = factory(Client::class)->create([
            'name'           => 'Old name',
            'client_code'    => 'test_code',
            'annual_revenue' => 111
        ]);

        $response = $this->asManager()->postJson("/admin/clients/{$client->id}", [
            'name'           => 'New name',
            'annual_revenue' => 222
        ]);
        $response->assertStatus(200);

        $this->assertEquals('New name', $response->json('name'));
        $this->assertEquals('test_code', $response->json('client_code'));
        $this->assertEquals(222, $response->json('annual_revenue'));

        $this->assertDatabaseHas('clients', [
            'id'             => $client->id,
            'client_code'    => 'test_code',
            'name'           => 'New name',
            'annual_revenue' => 222
        ]);
    }

    /**
     *@test
     */
    public function a_client_can_only_be_updated_by_a_manager()
    {
        $client = factory(Client::class)->create([
            'name'           => 'Old name',
            'client_code'    => 'test_code',
            'annual_revenue' => 111
        ]);

        $response = $this->asStaff()->postJson("/admin/clients/{$client->id}", [
            'name'           => 'New name',
            'annual_revenue' => 222
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('clients', [
            'id'             => $client->id,
            'client_code'    => 'test_code',
            'name'           => 'Old name',
            'annual_revenue' => 111
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $client = factory(Client::class)->create([
            'name'           => 'Old name',
            'client_code'    => 'test_code',
            'annual_revenue' => 111
        ]);

        $response = $this->asManager()->postJson("/admin/clients/{$client->id}", [
            'name'           => '',
            'annual_revenue' => 222
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_annual_revenue_is_required()
    {
        $client = factory(Client::class)->create([
            'name'           => 'Old name',
            'client_code'    => 'test_code',
            'annual_revenue' => 111
        ]);

        $response = $this->asManager()->postJson("/admin/clients/{$client->id}", [
            'name'           => 'New name',
            'annual_revenue' => null
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('annual_revenue');
    }

    /**
     *@test
     */
    public function the_annual_revenue_must_be_an_integer()
    {
        $client = factory(Client::class)->create([
            'name'           => 'Old name',
            'client_code'    => 'test_code',
            'annual_revenue' => 111
        ]);

        $response = $this->asManager()->postJson("/admin/clients/{$client->id}", [
            'name'           => 'New name',
            'annual_revenue' => 'not-an-integer'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('annual_revenue');
    }
}
