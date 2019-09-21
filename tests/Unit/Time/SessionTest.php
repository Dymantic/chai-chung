<?php

namespace Test\Unit\Time;

use App\Clients\Client;
use App\Clients\EngagementCode;
use App\Time\Session;
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
            'start_time' => Carbon::now()->subHours(3)->setMinutes(30),
            'end_time' => Carbon::now()->subHours(1)->setMinutes(30),
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $session = $user->addSession($session_data);

//        $this->assertTrue($session->start_time->isToday());
        $this->assertEquals('2 小時', $session->duration()->asString());
        $this->assertEquals(Carbon::today()->year, $session->service_period);
        $this->assertTrue($session->client->is($client));
        $this->assertTrue($session->engagement_code->is($engagement_code));
        $this->assertEquals('test description', $session->description);
        $this->assertEquals('test notes', $session->notes);
    }

    /**
     *@test
     */
    public function a_session_can_set_the_overtime()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();

        $session = Session::forceCreate([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('last friday')->setHour(10)->setMinutes(30),
            'end_time' => Carbon::parse('last friday')->setHour(12)->setMinutes(30),
            'on_holiday' => true,
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ]);

        $session->setOvertime();

        $this->assertEquals(120, $session->fresh()->overtime_minutes);


    }

    /**
     *@test
     */
    public function session_cost()
    {
        $user = factory(User::class)->create(['hourly_rate' => 500]);
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();

        $sessionA = Session::forceCreate([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('last friday')->setHour(10)->setMinutes(30),
            'end_time' => Carbon::parse('last friday')->setHour(12)->setMinutes(30),
            'on_holiday' => true,
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ]);

        $sessionB = Session::forceCreate([
            'user_id' => $user->id,
            'start_time' => Carbon::parse('last friday')->setHour(14)->setMinutes(0),
            'end_time' => Carbon::parse('last friday')->setHour(17)->setMinutes(30),
            'on_holiday' => true,
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ]);

        $this->assertEquals(1000, $sessionA->cost());
        $this->assertEquals(1750, $sessionB->cost());
    }
}