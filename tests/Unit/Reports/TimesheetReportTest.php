<?php


namespace Tests\Unit\Reports;


use App\Reports\TimesheetReport;
use App\Time\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TimesheetReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function reports_on_time_sessions_for_given_dates()
    {
        $before = Carbon::today()->subDays(15);
        $start = Carbon::today()->subDays(10);
        $middle = Carbon::today()->subDays(7);
        $end = Carbon::today()->subDays(5);
        $after = Carbon::today()->subDays(3);

        $this->createSessionsOnDay($before, 3);
        $inclA = $this->createSessionsOnDay($start, 4);
        $inclB = $this->createSessionsOnDay($middle, 5);
        $inclC = $this->createSessionsOnDay($end, 1);
        $this->createSessionsOnDay($after, 2);

        $included = $inclA->merge($inclB)->merge($inclC);

        $expected_rows = $included->map(function($session) {
            $data = $session->toArray();
            $overtime = $data['overtime'] ? $data['overtime'] / 60 : 0;
            return [
                $data['date'],
                $data['user'],
                "{$data['start_time']} - {$data['end_time']}",
                $data['duration'],
                $data['client_name'],
                $data['engagement_code_description'],
                $data['description'],
                $data['notes'],
                $overtime >= 2 ? 2 : $overtime,
                $overtime >= 2 ? $overtime - 2 : 0,
                $overtime,
            ];
        });

        $expected_headings = [
            '日期',
            '員工',
            '時間',
            '時間長度',
            '客戶',
            '工作事項',
            '描述',
            '備註',
            '加班 (２小時以內)',
            '加班（２小時以外的時數)',
            '加班 (總時數)',
        ];

        $expected_slug = "timesheet_{$start->format('Y_m_d')}_to_{$end->format('Y_m_d')}";

        $report = new TimesheetReport($start, $end);

        $this->assertCount(10, $report->rows());
        $this->assertEquals($expected_rows, $report->rows());
        $this->assertEquals($expected_headings, $report->headings());
        $this->assertEquals($expected_slug, $report->slug());
    }

    private function createSessionsOnDay($date, $number)
    {
        return collect(range(1,$number))
            ->map(function($index) use ($date) {
                return factory(Session::class)->create([
                    'start_time' => Carbon::parse($date)->setHour($index + 8)->setMinutes(0),
                    'end_time' => Carbon::parse($date)->setHour($index + 9)->setMinutes(0),
                ]);
            });
    }
}
