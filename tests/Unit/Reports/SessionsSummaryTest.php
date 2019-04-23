<?php

namespace Tests\Unit\Reports;

use App\Time\Session;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionsSummaryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_summary_can_be_created_for_a_given_time_period()
    {
        $this->createSession(1, 2);
        $this->createSession(1, 3);
        $this->createSession(2, 1);
        $this->createSession(3, 2, true);
        $this->createSession(4, 2, true);
        $this->createSession(4, 3);

        $summary = Session::summary([
            'from' => Carbon::today()->subDays(10),
            'to' => Carbon::today()->endOfDay()
        ]);

        $this->assertEquals(13 * 60, $summary->total_time());
        $this->assertEquals(4 * 60, $summary->total_overtime());
    }

    private function createSession($days_ago, $hours, $is_overtime = false)
    {
        return factory(Session::class)->create([
            'start_time' => Carbon::today()->subDays($days_ago)->setHours(14)->setMinutes(0),
            'end_time' => Carbon::today()->subDays($days_ago)->setHours(14 + $hours)->setMinutes(0),
            'on_holiday' => $is_overtime
        ]);
    }
}