<?php


namespace Tests\Unit\Clients;


use App\Clients\Client;
use App\Clients\EngagementCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasturedClientsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function safe_delete_a_client()
    {
        $client = factory(Client::class)->create();
        $this->assertNull($client->pastured_on);

        $client->safeDelete();
        $client = $client->fresh();

        $this->assertDatabaseHas('clients', ['id' => $client->id]);
        $this->assertTrue($client->pastured_on->isToday());
        $this->assertTrue($client->isPastured());
    }

    /**
     *@test
     */
    public function safe_delete_an_engagement_code()
    {
        $code = factory(EngagementCode::class)->create();
        $this->assertNull($code->pastured_on);

        $code->safeDelete();
        $code = $code->fresh();

        $this->assertDatabaseHas('engagement_codes', ['id' => $code->id]);
        $this->assertTrue($code->pastured_on->isToday());
        $this->assertTrue($code->isPastured());
    }
}