<?php


namespace Tests\Unit\Reports;


use App\Clients\Client;
use App\Reports\ClientCostReport;
use App\Reports\ClientCostSummary;
use App\Time\Session;
use App\Time\TimeOfDay;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ClientCostSummaryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function summarize_cost_of_client_over_period_of_time()
    {
        $staffA = factory(User::class)->create(['hourly_rate' => 300]);
        $staffB = factory(User::class)->create(['hourly_rate' => 400]);
        $staffC = factory(User::class)->create(['hourly_rate' => 500]);

        $clientA = factory(Client::class)->create(['annual_revenue' => 1000000]);
        $clientB = factory(Client::class)->create(['annual_revenue' => 2000000]);
        $clientC = factory(Client::class)->create(['annual_revenue' => 3000000]);

        $month_start = Carbon::today()->subMonth()->startOfMonth();
        $month_end = Carbon::today()->subMonth()->endOfMonth();
        $working_days = 0;

        //standard time
        // clientA: staffA 4 hours, staffB 2 hours, staffC 6 hours
        // clientB: staffA 3.5 hours, staffB 2 hours, staffC 2 hours
        // clientA: staffA 0.5 hours, staffB 3 hours, staffC 0 hours
        foreach(CarbonPeriod::create($month_start, $month_end) as $day) {
            if($day->isWeekday()) {
                $this->logSession($clientA, $staffA, $day, [['08:30', '10:30'], ['13:30', '15:30']]);
                $this->logSession($clientA, $staffB, $day, [['08:30', '10:30']]);
                $this->logSession($clientA, $staffC, $day, [['08:30', '10:30'], ['13:30', '17:30']]);

                $this->logSession($clientB, $staffA, $day, [['10:30', '12:30'], ['15:30', '17:00']]);
                $this->logSession($clientB, $staffB, $day, [['10:30', '12:30']]);
                $this->logSession($clientB, $staffC, $day, [['10:30', '12:30']]);

                $this->logSession($clientC, $staffA, $day, [['17:00', '17:30']]);
                $this->logSession($clientC, $staffB, $day, [['13:30', '16:30']]);

                $working_days++;
            }
        }

        //overtime
        // clientA 3 hours, clientB 2 hours, clientC 0 hours
        $this->logSession($clientA, $staffA, Carbon::parse('first friday last month'), [['19:00', '20:30']]);
        $this->logSession($clientB, $staffA, Carbon::parse('second wednesday last month'), [['19:00', '21:00']]);
        $this->logSession($clientA, $staffA, Carbon::parse('first thursday last month'), [['19:00', '20:30']]);



        $expected = [
            'start' => $month_start->format('Y-m-d'),
            'end' => $month_end->format('Y-m-d'),
            'clients' => [
                [
                    'id' => $clientA->id,
                    'code' => $clientA->client_code,
                    'name' => $clientA->name,
                    'total_hours' => (12 * $working_days) + 3,
                    'overtime_hours' => 3,
                    'cost' => ($working_days * ((4 * 300) + (2 * 400) + (6 * 500))) + (3 * 300),
                    'annual_revenue' => 1000000
                ],
                [
                    'id' => $clientB->id,
                    'code' => $clientB->client_code,
                    'name' => $clientB->name,
                    'total_hours' => (7.5 * $working_days) + 2,
                    'overtime_hours' => 2,
                    'cost' => ($working_days * ((3.5 * 300) + (2 * 400) + (2 * 500))) + (2 * 300),
                    'annual_revenue' => 2000000
                ],
                [
                    'id' => $clientC->id,
                    'code' => $clientC->client_code,
                    'name' => $clientC->name,
                    'total_hours' => 3.5 * $working_days,
                    'overtime_hours' => 0,
                    'cost' => (0.5 * 300 * $working_days) + (3 * 400 * $working_days) + (0 * 500 * $working_days),
                    'annual_revenue' => 3000000
                ]
            ],
        ];

        $summary = new ClientCostSummary($month_start, $month_end);

        $this->assertEquals($expected, $summary->toArray());
    }

    /**
     *@test
     */
    public function save_summary_to_db()
    {
        $staffA = factory(User::class)->create(['hourly_rate' => 300]);
        $staffB = factory(User::class)->create(['hourly_rate' => 400]);
        $staffC = factory(User::class)->create(['hourly_rate' => 500]);

        $clientA = factory(Client::class)->create(['annual_revenue' => 1000000]);
        $clientB = factory(Client::class)->create(['annual_revenue' => 2000000]);
        $clientC = factory(Client::class)->create(['annual_revenue' => 3000000]);

        $month_start = Carbon::today()->subMonth()->firstOfMonth();
        $month_end = Carbon::today()->subMonth()->lastOfMonth();
        $working_days = 0;

        //standard time
        // clientA: staffA 4 hours, staffB 2 hours, staffC 6 hours
        // clientB: staffA 3.5 hours, staffB 2 hours, staffC 2 hours
        // clientA: staffA 0.5 hours, staffB 3 hours, staffC 0 hours
        foreach(CarbonPeriod::create($month_start, $month_end) as $day) {
            if($day->isWeekday()) {
                $this->logSession($clientA, $staffA, $day, [['08:30', '10:30'], ['13:30', '15:30']]);
                $this->logSession($clientA, $staffB, $day, [['08:30', '10:30']]);
                $this->logSession($clientA, $staffC, $day, [['08:30', '10:30'], ['13:30', '17:30']]);

                $this->logSession($clientB, $staffA, $day, [['10:30', '12:30'], ['15:30', '17:00']]);
                $this->logSession($clientB, $staffB, $day, [['10:30', '12:30']]);
                $this->logSession($clientB, $staffC, $day, [['10:30', '12:30']]);

                $this->logSession($clientC, $staffA, $day, [['17:00', '17:30']]);
                $this->logSession($clientC, $staffB, $day, [['13:30', '16:30']]);

                $working_days++;
            }
        }

        //overtime
        // clientA 3 hours, clientB 2 hours, clientC 0 hours
        $this->logSession($clientA, $staffA, Carbon::parse('first wednesday last month'), [['19:00', '20:30']]);
        $this->logSession($clientB, $staffA, Carbon::parse('second wednesday last month'), [['19:00', '21:00']]);
        $this->logSession($clientA, $staffA, Carbon::parse('first friday last month'), [['19:00', '20:30']]);

        $summary = new ClientCostSummary($month_start, $month_end);
        $summary->save();

        $this->assertCount(1, ClientCostReport::all());
        $report = ClientCostReport::first();

//        $this->assertDatabaseHas('client_cost_reports', [
//            'id' => $report->id,
//            'start_date' => $month_start,
//            'end_date' => $month_end,
//        ]);

        $this->assertDatabaseHas('client_cost_entries', [
            'client_cost_report_id' => $report->id,
            'client_id' => $clientA->id,
            'total_hours' => (12 * $working_days) + 3,
            'overtime_hours' => 3,
            'cost' => ($working_days * ((4 * 300) + (2 * 400) + (6 * 500))) + (3 * 300),
            'annual_revenue' => 1000000
        ]);

        $this->assertDatabaseHas('client_cost_entries', [
            'client_cost_report_id' => $report->id,
            'client_id' => $clientB->id,
            'total_hours' => (7.5 * $working_days) + 2,
            'overtime_hours' => 2,
            'cost' => ($working_days * ((3.5 * 300) + (2 * 400) + (2 * 500))) + (2 * 300),
            'annual_revenue' => 2000000
        ]);

        $this->assertDatabaseHas('client_cost_entries', [
            'client_cost_report_id' => $report->id,
            'client_id' => $clientC->id,
            'total_hours' => 3.5 * $working_days,
            'overtime_hours' => 0,
            'cost' => (0.5 * 300 * $working_days) + (3 * 400 * $working_days) + (0 * 500 * $working_days),
            'annual_revenue' => 3000000
        ]);

    }

    private function logSession($client, $user, $day, $times)
    {
        foreach ($times as $time) {
            $start = new TimeOfDay($time[0]);
            $end = new TimeOfDay($time[1]);
            $start_time = Carbon::parse($day)->setHour($start->hours)->setMinutes($start->mins);
            $end_time = Carbon::parse($day)->setHour($end->hours)->setMinutes($end->mins);
            factory(Session::class)->create([
                'user_id' => $user->id,
                'client_id' => $client->id,
                'start_time' => $start_time,
                'end_time' => $end_time
            ]);
        }
    }
}