<?php


namespace Tests\Unit\Time;


use App\Time\TimeOfDay;
use Tests\TestCase;

class TimeOfDayTest extends TestCase
{
    /**
     *@test
     */
    public function it_can_check_if_time_is_before()
    {
        $time = new TimeOfDay("10:00");

        $this->assertTrue((new TimeOfDay("9:00"))->isBefore($time));
        $this->assertTrue((new TimeOfDay("09:00"))->isBefore($time));
        $this->assertTrue((new TimeOfDay("1:00"))->isBefore($time));

        $this->assertFalse((new TimeOfDay("19:00"))->isBefore($time));
        $this->assertFalse((new TimeOfDay("11:00"))->isBefore($time));
        $this->assertFalse((new TimeOfDay("10:00"))->isBefore($time));
    }

    /**
     *@test
     */
    public function checks_for_equal_time()
    {
        $time = new TimeOfDay("9:00");

        $this->assertTrue((new TimeOfDay("09:00"))->isEqualTo($time));
        $this->assertTrue((new TimeOfDay("9:00"))->isEqualTo($time));

        $this->assertFalse((new TimeOfDay("09:01"))->isEqualTo($time));
        $this->assertFalse((new TimeOfDay("19:00"))->isEqualTo($time));
    }
}