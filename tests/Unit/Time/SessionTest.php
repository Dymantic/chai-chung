<?php

namespace Test\Unit\Time;

use App\Clients\Client;
use App\Clients\EngagementCode;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_session_can_be_created_for_a_user()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();

        $session_data = [
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => Carbon::now()->subHours(3)->hour . ":30",
            'end_time' => Carbon::now()->subHours(1)->hour . ":30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $session = $user->addSession($session_data);

        $this->assertTrue($session->start_time->isToday());
        $this->assertEquals(120, $session->duration());
        $this->assertEquals(Carbon::today()->year, $session->service_period);
        $this->assertTrue($session->client->is($client));
        $this->assertTrue($session->engagement_code->is($engagement_code));
        $this->assertEquals('test description', $session->description);
        $this->assertEquals('test notes', $session->notes);
    }
}