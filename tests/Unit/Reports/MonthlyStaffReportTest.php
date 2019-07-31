<?php


namespace Tests\Unit\Reports;


use App\Reports\StaffCostReport;
use App\Reports\StaffCostSummary;
use App\Time\Session;
use App\Time\TimeOfDay;
use App\User;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MonthlyStaffReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function generate_the_report()
    {
        $staffA = factory(User::class)->create(['hourly_rate' => 400]);
        $staffB = factory(User::class)->create(['hourly_rate' => 700]);
        $staffC = factory(User::class)->create(['hourly_rate' => 500]);

        $month_start = Carbon::today()->subMonth()->firstOfMonth();
        $month_end = Carbon::today()->subMonth()->lastOfMonth();

        $period = CarbonPeriod::create($month_start, $month_end);
        $total_days = 0;

        foreach ($period as $day) {
            if ($day->isWeekday()) {
                $this->logSessions($staffA, $day, [
                    ["08:30", "10:30"],
                    ["10:30", "12:30"],
                    ["13:00", "15:00"],
                    ["15:00", "17:00"]
                ]);

                $this->logSessions($staffB, $day, [
                    ["08:30", "10:30"],
                    ["10:30", "12:30"],
                ]);
                $this->logSessions($staffC, $day, [
                    ["10:30", "12:30"],
                    ["13:00", "15:00"],
                    ["15:00", "17:00"]
                ]);
                $total_days++;
            }
        }


        //set overtime
        $this->logSessions($staffA, Carbon::parse('last Wednesday')->subMonth(), [
            ["07:00", "8:00"], ["18:30", "20:30"]
        ]);
        $this->logSessions($staffA, Carbon::parse('last Friday')->subMonth(), [
            ["18:30", "20:30"]
        ]);


        $expected = [
            'start_date' => $month_start->format('Y-m-d'),
            'end_date' => $month_end->format('Y-m-d'),
            'staff' => [
                [
                    'id' => $staffA->id,
                    'name' => $staffA->name,
                    'total_hours' => ($total_days * 8) + 5,
                    'overtime_hours' => 5,
                    'hourly_rate' => 400,
                    'cost' => (400 * ($total_days * 8)) + (1600 * 1.33) + (400 * 1.67)
                ],
                [
                    'id' => $staffB->id,
                    'name' => $staffB->name,
                    'total_hours' => ($total_days * 4),
                    'overtime_hours' => 0,
                    'hourly_rate' => 700,
                    'cost' => 700 * ($total_days * 4)
                ],
                [
                    'id' => $staffC->id,
                    'name' => $staffC->name,
                    'total_hours' => ($total_days * 6),
                    'overtime_hours' => 0,
                    'hourly_rate' => 500,
                    'cost' => 500 * ($total_days * 6)
                ]
            ]
        ];

        $this->assertEquals($expected, (new StaffCostSummary($month_start, $month_end))->toArray());

    }

    /**
     *@test
     */
    public function save_a_report()
    {
        $staffA = factory(User::class)->create(['hourly_rate' => 400]);
        $staffB = factory(User::class)->create(['hourly_rate' => 700]);
        $staffC = factory(User::class)->create(['hourly_rate' => 500]);

        $month_start = Carbon::today()->subMonth()->firstOfMonth();
        $month_end = Carbon::today()->subMonth()->lastOfMonth();

        $period = CarbonPeriod::create($month_start, $month_end);
        $total_days = 0;

        foreach ($period as $day) {
            if ($day->isWeekday()) {
                $this->logSessions($staffA, $day, [
                    ["08:30", "10:30"],
                    ["10:30", "12:30"],
                    ["13:00", "15:00"],
                    ["15:00", "17:00"]
                ]);

                $this->logSessions($staffB, $day, [
                    ["08:30", "10:30"],
                    ["10:30", "12:30"],
                ]);
                $this->logSessions($staffC, $day, [
                    ["10:30", "12:30"],
                    ["13:00", "15:00"],
                    ["15:00", "17:00"]
                ]);
                $total_days++;
            }
        }


        //set overtime
        $this->logSessions($staffA, Carbon::parse('second Wednesday last month'), [
            ["07:00", "8:00"], ["18:30", "20:30"]
        ]);
        $this->logSessions($staffA, Carbon::parse('second Friday last month'), [
            ["18:30", "20:30"]
        ]);

        $summary = new StaffCostSummary($month_start, $month_end);
        $summary->save();

        $this->assertDatabaseHas('staff_cost_reports', [
            'start_date' => $month_start,
            'end_date' => $month_end,
        ]);

        $this->assertCount(1, StaffCostReport::all());
        $staffCostReport = StaffCostReport::first();

        $this->assertDatabaseHas('staff_cost_entries', [
            'staff_cost_report_id' => $staffCostReport->id,
            'user_id' => $staffA->id,
            'total_hours' => ($total_days * 8) + 5,
            'overtime_hours' => 5,
            'hourly_rate' => 400,
            'cost' => (400 * ($total_days * 8)) + 2796
        ]);

        $this->assertDatabaseHas('staff_cost_entries', [
            'staff_cost_report_id' => $staffCostReport->id,
            'user_id' => $staffB->id,
            'total_hours' => ($total_days * 4),
            'overtime_hours' => 0,
            'hourly_rate' => 700,
            'cost' => 700 * ($total_days * 4)
        ]);

        $this->assertDatabaseHas('staff_cost_entries', [
            'staff_cost_report_id' => $staffCostReport->id,
            'user_id' => $staffC->id,
            'total_hours' => ($total_days * 6),
            'overtime_hours' => 0,
            'hourly_rate' => 500,
            'cost' => 500 * ($total_days * 6)
        ]);
    }

    private function logSessions($user, $day, $times)
    {
        foreach ($times as $time) {
            $start = new TimeOfDay($time[0]);
            $end = new TimeOfDay($time[1]);
            $start_time = Carbon::parse($day)->setHour($start->hours)->setMinutes($start->mins);
            $end_time = Carbon::parse($day)->setHour($end->hours)->setMinutes($end->mins);
            factory(Session::class)->create([
                'user_id' => $user->id,
                'start_time' => $start_time,
                'end_time' => $end_time
            ]);
        }
    }
}