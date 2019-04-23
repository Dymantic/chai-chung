<?php


namespace Tests\Unit\Time;


use App\Clients\Client;
use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SessionsQueryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function sessions_in_date_range()
    {
        $sessionA = $this->makeSession(Carbon::today()->subDays(20));
        $sessionB = $this->makeSession(Carbon::today()->subDays(10));
        $sessionC = $this->makeSession(Carbon::today()->subDays(5));

        $query_results = Session::matching([
            'from' => Carbon::today()->subDays(14)->format('Y-m-d'),
            'to' => Carbon::today()->format('Y-m-d')
        ]);

        $this->assertCount(2, $query_results);
        $this->assertNotContains($sessionA->id, $query_results->pluck('id')->all());
        $this->assertContains($sessionB->id, $query_results->pluck('id')->all());
        $this->assertContains($sessionC->id, $query_results->pluck('id')->all());
    }

    /**
     *@test
     */
    public function in_date_range_and_for_client()
    {
        $client = factory(Client::class)->create();

        $sessionA = $this->makeSession(Carbon::today()->subDays(20));
        $sessionB = $this->makeSession(Carbon::today()->subDays(10));
        $sessionC = $this->makeSession(Carbon::today()->subDays(5), "10:00", "12:00", $client);

        $query_results = Session::matching([
            'from' => Carbon::today()->subDays(14)->format('Y-m-d'),
            'to' => Carbon::today()->format('Y-m-d'),
            'client_id' => $client->id
        ]);

        $this->assertCount(1, $query_results);
        $this->assertNotContains($sessionA->id, $query_results->pluck('id')->all());
        $this->assertNotContains($sessionB->id, $query_results->pluck('id')->all());
        $this->assertContains($sessionC->id, $query_results->pluck('id')->all());
    }

    /**
     *@test
     */
    public function in_date_range_for_client_and_user()
    {
        $client = factory(Client::class)->create();
        $wrong_client = factory(Client::class)->create();
        $user = factory(User::class)->create();

        $sessionA = $this->makeSession(Carbon::today()->subDays(20), "10:00", "12:00", $client, $user);
        $sessionB = $this->makeSession(Carbon::today()->subDays(10));
        $sessionC = $this->makeSession(Carbon::today()->subDays(5), "10:00", "12:00", $client, $user);
        $sessionD = $this->makeSession(Carbon::today()->subDays(5), "10:00", "12:00", $client);
        $sessionE = $this->makeSession(Carbon::today()->subDays(5), "10:00", "12:00", $wrong_client, $user);

        $query_results = Session::matching([
            'from' => Carbon::today()->subDays(7)->format('Y-m-d'),
            'to' => Carbon::today()->format('Y-m-d'),
            'client_id' => $client->id,
            'user_id' => $user->id
        ]);

        $this->assertCount(1, $query_results);
        $this->assertNotContains($sessionA->id, $query_results->pluck('id')->all());
        $this->assertNotContains($sessionB->id, $query_results->pluck('id')->all());
        $this->assertContains($sessionC->id, $query_results->pluck('id')->all());
        $this->assertNotContains($sessionD->id, $query_results->pluck('id')->all());
        $this->assertNotContains($sessionE->id, $query_results->pluck('id')->all());
    }

    private function makeSession($date, $from = "10:00", $to = "12:00", $client = null, $user = null)
    {
        $start_hours = intval(substr($from, 0, 2));
        $start_mins = intval(substr($from, 3, 2));

        $end_hours = intval(substr($to, 0, 2));
        $end_mins = intval(substr($to, 3, 2));

        return factory(Session::class)->create([
            'start_time' => Carbon::parse($date)->setHours($start_hours)->setMinutes($start_mins),
            'end_time' => Carbon::parse($date)->setHours($end_hours)->setMinutes($end_mins),
            'client_id' => $client ? $client->id : factory(Client::class)->create(),
            'user_id' => $user ? $user->id : factory(User::class)->create()
        ]);
    }
}