<?php


namespace Tests\Unit\Reports;


use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StaffTimeReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_report_that_shows_time_per_staff_for_a_given_date_range()
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();
        $staffC = factory(User::class)->create();

        $this->createSession($staffA, 1, 2);
        $this->createSession($staffA, 2, 3);
        $this->createSession($staffA, 3, 1, true);
        $this->createSession($staffA, 21, 1);

        $this->createSession($staffB, 1, 2, true);
        $this->createSession($staffB, 3, 3);
        $this->createSession($staffB, 2, 2, true);
        $this->createSession($staffB, 21, 3);

        $this->createSession($staffC, 1, 3);
        $this->createSession($staffC, 2, 3);
        $this->createSession($staffC, 3, 2);
        $this->createSession($staffC, 21, 1);

        $report = Session::staffTimeReport([
            'from' => Carbon::today()->subDays(7),
            'to' => Carbon::today()->endOfDay()
        ]);

        $expected_rows = [
            [
                'id' => $staffA->id,
                'name' => $staffA->name,
                'time' => 6*60,
                'overtime' => 1*60
            ],
            [
                'id' => $staffB->id,
                'name' => $staffB->name,
                'time' => 7*60,
                'overtime' => 4*60
            ],
            [
                'id' => $staffC->id,
                'name' => $staffC->name,
                'time' => 8*60,
                'overtime' => 0*60
            ],
        ];

        $this->assertEquals($expected_rows, $report['rows']);
    }

    private function createSession($user, $days_ago, $hours, $is_overtime = false)
    {
        return factory(Session::class)->create([
            'user_id'    => $user->id,
            'start_time' => Carbon::parse('last friday')->subDays($days_ago)->setHours(14)->setMinutes(0),
            'end_time'   => Carbon::parse('last friday')->subDays($days_ago)->setHours(14 + $hours)->setMinutes(0),
            'on_holiday' => $is_overtime
        ]);
    }
}