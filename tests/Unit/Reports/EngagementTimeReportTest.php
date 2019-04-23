<?php


namespace Tests\Unit\Reports;


use App\Clients\EngagementCode;
use App\Time\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EngagementTimeReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function report_time_for_engagement_codes_in_given_date_range()
    {
        $engagementA = factory(EngagementCode::class)->create();
        $engagementB = factory(EngagementCode::class)->create();
        $engagementC = factory(EngagementCode::class)->create();

        $this->createSession($engagementA, 1, 2);
        $this->createSession($engagementA, 2, 1);
        $this->createSession($engagementA, 3, 1, true);
        $this->createSession($engagementA, 21, 2);

        $this->createSession($engagementB, 1, 2, true);
        $this->createSession($engagementB, 2, 3);
        $this->createSession($engagementB, 3, 3, true);
        $this->createSession($engagementB, 21, 2);

        $this->createSession($engagementC, 1, 2);
        $this->createSession($engagementC, 2, 3);
        $this->createSession($engagementC, 3, 1);
        $this->createSession($engagementC, 21, 2);

        $expected_rows = [
            [
                'id' => $engagementA->id,
                'name' => $engagementA->description,
                'time' => 4*60,
                'overtime' => 1*60
            ],
            [
                'id' => $engagementB->id,
                'name' => $engagementB->description,
                'time' => 8*60,
                'overtime' => 5*60
            ],
            [
                'id' => $engagementC->id,
                'name' => $engagementC->description,
                'time' => 6*60,
                'overtime' => 0*60
            ],
        ];

        $report = Session::engagementTimeReport([
            'from' => Carbon::parse('14 days ago'),
            'to' => Carbon::today()
        ]);

        $this->assertEquals($expected_rows, $report['rows']);
    }

    private function createSession($engagement, $days_ago, $hours, $is_overtime = false)
    {
        return factory(Session::class)->create([
            'engagement_code_id'  => $engagement->id,
            'start_time' => Carbon::parse('last friday')->subDays($days_ago)->setHours(14)->setMinutes(0),
            'end_time'   => Carbon::parse('last friday')->subDays($days_ago)->setHours(14 + $hours)->setMinutes(0),
            'on_holiday' => $is_overtime
        ]);
    }
}