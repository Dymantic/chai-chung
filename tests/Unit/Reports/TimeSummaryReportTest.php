<?php


namespace Tests\Unit\Reports;


use App\Exports\SheetExport;
use App\Reports\DailyHoursReport;
use App\Reports\MultisheetReport;
use App\Reports\TimesheetReport;
use App\Reports\TimeSummaryReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TimeSummaryReportTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function create_a_time_summary_report()
    {
        $from = Carbon::today()->subDays(10);
        $to = Carbon::today()->subDay();

        $report = new TimeSummaryReport($from, $to);

        $expected_slug = "timesheet_{$from->format('m_d_Y')}_to_{$to->format('m_d_Y')}";
        $this->assertInstanceOf(MultisheetReport::class, $report);
        $this->assertCount(2, $report->sheets());
        $this->assertInstanceOf(SheetExport::class, $report->sheets()[0]);
        $this->assertInstanceOf(SheetExport::class, $report->sheets()[1]);
        $this->assertEquals($expected_slug, $report->slug());
    }
}
