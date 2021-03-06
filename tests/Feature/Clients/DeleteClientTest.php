<?php


namespace Tests\Feature\Clients;


use App\Clients\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_client_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $client = factory(Client::class)->create();

        $response = $this->asManager()->deleteJson("/admin/clients/{$client->id}");
        $response->assertStatus(200);

        $this->assertTrue($client->fresh()->isPastured());
    }

    /**
     *@test
     */
    public function only_a_manager_can_delete_a_client()
    {
        $client = factory(Client::class)->create();

        $response = $this->asStaff()->deleteJson("/admin/clients/{$client->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }
}