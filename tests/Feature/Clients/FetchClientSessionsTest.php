<?php


namespace Tests\Feature\Clients;


use App\Clients\Client;
use App\Time\Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchClientSessionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_clients_sessions_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $client = factory(Client::class)->create();
        $other_client = factory(Client::class)->create();
        $start_day = Carbon::today()->subDays(50);
        $period = CarbonPeriod::create($start_day, Carbon::today());

        foreach($period as $day) {
            factory(Session::class)->create([
                'client_id' => $client->id,
                'start_time' => $day->setHours(8)->setMinutes(0),
                'end_time' => $day->setHours(10)->setMinutes(0),
            ]);
            factory(Session::class)->create([
                'client_id' => $client->id,
                'start_time' => $day->setHours(10)->setMinutes(0),
                'end_time' => $day->setHours(12)->setMinutes(0),
            ]);
            factory(Session::class)->create([
                'client_id' => $client->id,
                'start_time' => $day->setHours(14)->setMinutes(0),
                'end_time' => $day->setHours(16)->setMinutes(0),
            ]);
            factory(Session::class)->create([
                'client_id' => $other_client->id,
                'start_time' => $day->setHours(14)->setMinutes(0),
                'end_time' => $day->setHours(16)->setMinutes(0),
            ]);
        }

        $response = $this->asManager()->getJson("/admin/clients/{$client->id}/sessions");
        $response->assertStatus(200);

        $fetched_sessions = $response->json();

        $this->assertCount(50, $fetched_sessions);

        collect($fetched_sessions)->each(function($session) use ($client) {
            $this->assertEquals($client->id, $session['client_id']);
        });
    }
}
