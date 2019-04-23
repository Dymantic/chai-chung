<?php


namespace Tests\Unit\Reports;


use App\Clients\Client;
use App\Time\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ClientTimeReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function client_hours_for_a_given_date_range()
    {
        $clientA = factory(Client::class)->create();
        $clientB = factory(Client::class)->create();
        $clientC = factory(Client::class)->create();

        $this->createSession($clientA, 1, 2);
        $this->createSession($clientA, 2, 1);
        $this->createSession($clientA, 3, 1, true);
        $this->createSession($clientA, 21, 2);

        $this->createSession($clientB, 1, 2, true);
        $this->createSession($clientB, 2, 3);
        $this->createSession($clientB, 3, 3, true);
        $this->createSession($clientB, 21, 2);

        $this->createSession($clientC, 1, 2);
        $this->createSession($clientC, 2, 3);
        $this->createSession($clientC, 3, 1);
        $this->createSession($clientC, 21, 2);

        $expected_rows = [
            [
                'id' => $clientA->id,
                'name' => $clientA->name,
                'time' => 4*60,
                'overtime' => 1*60
            ],
            [
                'id' => $clientB->id,
                'name' => $clientB->name,
                'time' => 8*60,
                'overtime' => 5*60
            ],
            [
                'id' => $clientC->id,
                'name' => $clientC->name,
                'time' => 6*60,
                'overtime' => 0*60
            ],
        ];

        $report = Session::clientTimeReport([
            'from' => Carbon::parse('14 days ago'),
            'to' => Carbon::today()
        ]);

        $this->assertEquals($expected_rows, $report['rows']);
    }

    private function createSession($client, $days_ago, $hours, $is_overtime = false)
    {
        return factory(Session::class)->create([
            'client_id'    => $client->id,
            'start_time' => Carbon::parse('last friday')->subDays($days_ago)->setHours(14)->setMinutes(0),
            'end_time'   => Carbon::parse('last friday')->subDays($days_ago)->setHours(14 + $hours)->setMinutes(0),
            'on_holiday' => $is_overtime
        ]);
    }
}