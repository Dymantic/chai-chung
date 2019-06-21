<?php


namespace Tests\Unit\Time;


use App\Time\TimeOfDay;
use App\Time\TimePeriod;
use Tests\TestCase;

class TimePeriodTest extends TestCase
{

    /**
     *@test
     */
    public function it_gives_the_duration_in_minutes()
    {
        $sixty = new TimePeriod(new TimeOfDay("10:00"), new TimeOfDay("11:00"));
        $ninety =  new TimePeriod(new TimeOfDay("10:00"), new TimeOfDay("11:30"));
        $fifteen = new TimePeriod(new TimeOfDay("10:30"), new TimeOfDay("10:45"));

        $this->assertEquals(60, $sixty->duration());
        $this->assertEquals(90, $ninety->duration());
        $this->assertEquals(15, $fifteen->duration());
    }

    /**
     *@test
     */
    public function knows_overlapping_times()
    {
        $period = new TimePeriod(new TimeOfDay("10:00"), new TimeOfDay("11:00"));

        $overlaps_start = new TimePeriod(new TimeOfDay("9:30"), new TimeOfDay("10:30"));
        $overlaps_end = new TimePeriod(new TimeOfDay("10:30"), new TimeOfDay("11:30"));
        $envelopes = new TimePeriod(new TimeOfDay("9:30"), new TimeOfDay("11:30"));
        $same = new TimePeriod(new TimeOfDay("10:00"), new TimeOfDay("11:00"));

        $this->assertTrue($period->overlapsWith($overlaps_start));
        $this->assertTrue($period->overlapsWith($overlaps_end));
        $this->assertTrue($period->overlapsWith($envelopes));
        $this->assertTrue($period->overlapsWith($same));
    }
}