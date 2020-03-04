<?php


namespace Tests\Unit\Reports;


use App\Reports\DailyHoursReport;
use App\Reports\SimpleSheetReport;
use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DailyHoursReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function creates_a_report_for_daily_hours()
    {
        $schedule = collect([
            [
                'day' => Carbon::today()->subDays(5),
                'a_hours' => 5,
                'b_hours' => 9
            ],
            [
                'day' => Carbon::today()->subDays(4),
                'a_hours' => 11,
                'b_hours' => 8
            ],
            [
                'day' => Carbon::today()->subDays(3),
                'a_hours' => 7,
                'b_hours' => 12,
            ],
            [
                'day' => Carbon::today()->subDays(2),
                'a_hours' => 8,
                'b_hours' => 8
            ],
            [
                'day' => Carbon::today()->subDays(1),
                'a_hours' => 6,
                'b_hours' => 13
            ],
        ]);

        $staffA = factory(User::class)->state('staff')->create();
        $staffB = factory(User::class)->state('staff')->create();

        $schedule->each(function($day) use ($staffA, $staffB) {
            $this->createDaysSessions($day['day'], $staffA, $day['a_hours']);
            $this->createDaysSessions($day['day'], $staffB, $day['b_hours']);
        });

        $day_one_date = Carbon::today()->subDays(5)->format('m/d Y');
        $day_one_day = Carbon::today()->subDays(5)->format('D');
        $day_two_date = Carbon::today()->subDays(4)->format('m/d Y');
        $day_two_day = Carbon::today()->subDays(4)->format('D');
        $day_three_date = Carbon::today()->subDays(3)->format('m/d Y');
        $day_three_day = Carbon::today()->subDays(3)->format('D');
        $day_four_date = Carbon::today()->subDays(2)->format('m/d Y');
        $day_four_day = Carbon::today()->subDays(2)->format('D');
        $day_five_date = Carbon::today()->subDays(1)->format('m/d Y');
        $day_five_day = Carbon::today()->subDays(1)->format('D');

        $expected_rows = collect([
            [$day_one_date, $day_one_day, $staffA->name, 5, 0, 0, 0],
            [$day_two_date, $day_two_day, $staffA->name, 11, 2, 1, 3],
            [$day_three_date, $day_three_day, $staffA->name, 7, 0, 0, 0],
            [$day_four_date, $day_four_day, $staffA->name, 8, 0, 0, 0],
            [$day_five_date, $day_five_day, $staffA->name, 6, 0, 0, 0],
            ['', '', '', '', '', '', '',],
            [$day_one_date, $day_one_day, $staffB->name, 9, 1, 0, 1],
            [$day_two_date, $day_two_day, $staffB->name, 8, 0, 0, 0],
            [$day_three_date, $day_three_day, $staffB->name, 12, 2, 2, 4],
            [$day_four_date, $day_four_day, $staffB->name, 8, 0, 0, 0],
            [$day_five_date, $day_five_day, $staffB->name, 13, 2, 3, 5],
            ['', '', '', '', '', '', '',],
        ]);
//        dd($expected_rows);

        $expected_headings = [
            '日期', '星期', '員工', '時間長度', '加班 (２小時以內)', '加班（２小時以外的時數)', '加班 (總時數)',
        ];

        $expected_title = '每日總時數';

        $report = new DailyHoursReport(Carbon::today()->subDays(7), Carbon::today());

        $this->assertInstanceOf(SimpleSheetReport::class, $report);
        $this->assertEquals($expected_rows, $report->rows());
        $this->assertEquals($expected_title, $report->title());
        $this->assertEquals($expected_headings, $report->headings());


    }

    private function createDaysSessions($day, $user, $hours)
    {
        foreach (range(1, $hours) as $hour) {
            factory(Session::class)->create([
                'user_id' => $user->id,
                'start_time' => Carbon::parse($day)->setHour($hour + 8)->setMinutes(0),
                'end_time' => Carbon::parse($day)->setHour($hour + 9)->setMinutes(0),
            ]);
        }
    }
}
