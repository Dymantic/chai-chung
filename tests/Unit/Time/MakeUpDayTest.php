<?php


namespace Tests\Unit\Time;


use App\Time\MakeUpDay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MakeUpDayTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_make_up_day_can_be_created_for_a_given_date()
    {
        $today = Carbon::today();
        $day = MakeUpDay::forDate($today->format('Y-m-d'), 'test reason');

        $this->assertEquals($today->year, $day->year);
        $this->assertEquals($today->month, $day->month);
        $this->assertEquals($today->day, $day->day);
        $this->assertEquals('test reason', $day->reason);
    }
}