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

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}