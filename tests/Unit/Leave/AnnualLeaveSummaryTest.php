<?php


namespace Tests\Unit\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AnnualLeaveSummaryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function generate_report_of_leave_from_given_year()
    {
        $year = Carbon::now()->year;
        $last_year = factory(LeaveRequest::class)->create([
            'starts' => Carbon::create($year-1, 12, 12, 8, 30),
            'ends' => Carbon::create($year-1, 12, 12, 17, 30),
        ]);
        $overlapping = factory(LeaveRequest::class)->create([
            'starts' => Carbon::create($year-1, 12, 28, 8, 30),
            'ends' => Carbon::create($year, 1, 5, 17, 30),
        ]);
        $legit_A = factory(LeaveRequest::class)->create([
            'starts' => Carbon::create($year, 4, 14, 8, 30),
            'ends' => Carbon::create($year, 4, 15, 17, 30),
        ]);
        $legit_B = factory(LeaveRequest::class)->create([
            'starts' => Carbon::create($year, 5, 14, 8, 30),
            'ends' => Carbon::create($year, 5, 15, 17, 30),
        ]);

        $expected = [
            'head' => [
                'title' => 'Staff Leave Records for ' . $year,
                'starts' => "1/1 {$year}",
                'ends' => "12/31 {$year}",
                'columns' => ['代號', '姓名', '開始', '結束', '請假類別', '代班', '狀態', '理由'],
                'report_date' => Carbon::now()->format('m-d-Y'),
            ],
            'data' => [
                [
                    $overlapping->user->user_code,
                    $overlapping->user->name,
                    $overlapping->starts->format('m-d-Y, h:i'),
                    $overlapping->ends->format('m-d-Y, h:i'),
                    $overlapping->leave_type,
                    $overlapping->covered_by->name,
                    $overlapping->statusText(),
                    $overlapping->reason,
                ],
                [
                    $legit_A->user->user_code,
                    $legit_A->user->name,
                    $legit_A->starts->format('m-d-Y, h:i'),
                    $legit_A->ends->format('m-d-Y, h:i'),
                    $legit_A->leave_type,
                    $legit_A->covered_by->name,
                    $legit_A->statusText(),
                    $legit_A->reason,
                ],
                [
                    $legit_B->user->user_code,
                    $legit_B->user->name,
                    $legit_B->starts->format('m-d-Y, h:i'),
                    $legit_B->ends->format('m-d-Y, h:i'),
                    $legit_B->leave_type,
                    $legit_B->covered_by->name,
                    $legit_B->statusText(),
                    $legit_B->reason,
                ],
            ]
        ];

        $this->assertEquals($expected, LeaveRequest::annualSummary($year));
    }

    private function createRequest($staff, $start, $end)
    {

    }
}