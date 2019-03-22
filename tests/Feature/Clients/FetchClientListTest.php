<?php


namespace Tests\Feature\Clients;


use App\Clients\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchClientListTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_all_clients_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $clients = factory(Client::class, 10)->create();

        $response = $this->asManager()->getJson("/admin/clients");
        $response->assertStatus(200);

        $fetched_clients = $response->decodeResponseJson();

        $this->assertCount(10, $fetched_clients);
        $this->assertEquals($clients->map->toArray()->all(), $fetched_clients);
    }
}