<?php


namespace Tests\Unit\Time;


use App\Time\Holiday;
use App\Time\MakeUpDay;
use App\Time\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SessionOvertimeTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     *@test
     */
    public function overtime_for_after_hours()
    {
        $session = $this->makeSession(Carbon::parse("last friday"), "19:00", "20:00");
        $this->assertEquals(60, $session->overtime());
    }

    /**
     *@test
     */
    public function overtime_for_early_hours()
    {
        $session = $this->makeSession(Carbon::parse("last friday"), "05:00", "07:00");
        $this->assertEquals(120, $session->overtime());
    }

    /**
     *@test
     */
    public function overtime_for_overlapping_time()
    {
        $early_session = $this->makeSession(Carbon::parse("last friday"), "07:00", "10:00");
        $this->assertEquals(90, $early_session->overtime());

        $late_session = $this->makeSession(Carbon::parse("last friday"), "17:00", "19:00");
        $this->assertEquals(90, $late_session->overtime());
    }

    /**
     *@test
     */
    public function during_holiday()
    {
        $session = $this->makeSession(Carbon::today(), "15:00", "16:30", true);

        $this->assertEquals(90, $session->overtime());
    }

    /**
     *@test
     */
    public function on_weekends()
    {
        $sat_session = $this->makeSession(Carbon::parse('last Saturday'), "10:00", "12:00");
        $this->assertEquals(120, $sat_session->overtime());

        $sun_session = $this->makeSession(Carbon::parse('last Saturday'), "10:00", "12:00");
        $this->assertEquals(120, $sun_session->overtime());
    }

    /**
     *@test
     */
    public function during_make_up_day()
    {
        $session = $this->makeSession(Carbon::parse('last Saturday'), "10:00", "12:30", false, true);
        $this->assertEquals(0, $session->overtime());
    }

    /**
     *@test
     */
    public function no_overtime()
    {
        $session = $this->makeSession(Carbon::parse("last friday"), "14:00", "16:00");
        $this->assertEquals(0, $session->overtime());
    }

    private function makeSession($date, $from, $to, $on_holiday = false, $on_make_up_day = false)
    {
        $start_hours = intval(substr($from, 0, 2));
        $start_mins = intval(substr($from, 3, 2));

        $end_hours = intval(substr($to, 0, 2));
        $end_mins = intval(substr($to, 3, 2));

        return factory(Session::class)->create([
            'start_time' => Carbon::parse($date)->setHours($start_hours)->setMinutes($start_mins),
            'end_time' => Carbon::parse($date)->setHours($end_hours)->setMinutes($end_mins),
            'on_holiday' => $on_holiday,
            'on_make_up_day' => $on_make_up_day
        ]);
    }

    private function makeHoliday($date)
    {
        Holiday::setDates([
            'start' => $date,
            'end' => $date,
            'name' => 'test holiday'
        ]);
    }

    private function makeMakeUpDay($date)
    {
        MakeUpDay::create([
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day,
            'reason' => 'test reason'
        ]);
    }
}