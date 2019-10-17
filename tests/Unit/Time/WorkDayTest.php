<?php


namespace Tests\Unit\Time;


use App\Time\Session;
use App\Time\TimeOfDay;
use App\Time\TimePeriod;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class WorkDayTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function does_not_accept_session_that_results_in_more_than_four_consecutive_hours()
    {
        $logged_times = [
            '8:30' => '10:30',
            '10:30' => '12:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $new_session = new TimePeriod(new TimeOfDay("12:30"), new TimeOfDay("13:30"));
        $this->assertFalse($workDay->canAcceptSession($new_session));
    }

    /**
     *@test
     */
    public function does_not_accept_session_that_retroactively_makes_more_than_four_hours()
    {
        $logged_times = [
            '8:30' => '10:30',
            '12:30' => '13:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $new_session = new TimePeriod(new TimeOfDay("10:30"), new TimeOfDay("12:30"));
        $this->assertFalse($workDay->canAcceptSession($new_session));
    }

    /**
     *@test
     */
    public function does_not_accept_overlapping_times()
    {
        $logged_times = [
            '8:30' => '10:30',
            '10:30' => '12:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $new_session = new TimePeriod(new TimeOfDay("16:30"), new TimeOfDay("17:30"));
        $this->assertFalse($workDay->canAcceptSession($new_session));
    }

    /**
     *@test
     */
    public function does_not_accept_update_that_results_in_more_than_four_consecutive_hours()
    {
        $logged_times = [
            '8:30' => '10:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();
        $session = factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => (new TimeOfDay("10:30"))->asDate(),
            'end_time' => (new TimeOfDay("12:30"))->asDate(),
        ]);

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $updated_session = new TimePeriod(new TimeOfDay("10:30"), new TimeOfDay("13:30"));
        $this->assertFalse($workDay->canAcceptSessionUpdate($session->id, $updated_session));
    }

    /**
     *@test
     */
    public function does_not_accept_update_that_results_in_overlapping_sessions()
    {
        $logged_times = [
            '8:30' => '10:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();
        $session = factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => (new TimeOfDay("10:30"))->asDate(),
            'end_time' => (new TimeOfDay("12:30"))->asDate(),
        ]);

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $updated_session = new TimePeriod(new TimeOfDay("10:00"), new TimeOfDay("12:00"));
        $this->assertFalse($workDay->canAcceptSessionUpdate($session->id, $updated_session));
    }

    /**
     *@test
     */
    public function does_accept_legitimate_update()
    {
        $logged_times = [
            '8:30' => '10:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();
        $session = factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => (new TimeOfDay("10:30"))->asDate(),
            'end_time' => (new TimeOfDay("12:30"))->asDate(),
        ]);

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());
        $updated_session = new TimePeriod(new TimeOfDay("10:30"), new TimeOfDay("12:00"));
        $this->assertTrue($workDay->canAcceptSessionUpdate($session->id, $updated_session));
    }

    /**
     *@test
     */
    public function get_total_hours_of_day()
    {
        $logged_times = [
            '8:30' => '10:30',
            '10:30' => '12:30',
            '14:00' => '17:00',
        ];
        $user = factory(User::class)->create();

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());

        $this->assertEquals(7, $workDay->totalHours());
    }

    /**
     *@test
     */
    public function get_overtime_of_day()
    {
        $logged_times = [
            '18:30' => '20:00',
        ];
        $user = factory(User::class)->create();

        $this->prepareDay($logged_times, $user);

        $workDay = $user->workDay(Carbon::today());

        $this->assertEquals(1.5, $workDay->totalOvertime());
    }

    private function prepareDay($exsisting_sessions = [], $user)
    {
        collect($exsisting_sessions)->each(function($to, $start) use ($user) {
            factory(Session::class)->create([
                'user_id' => $user->id,
                'start_time' => (new TimeOfDay($start))->asDate(),
                'end_time' => (new TimeOfDay($to))->asDate(),
            ]);
        });
    }
}