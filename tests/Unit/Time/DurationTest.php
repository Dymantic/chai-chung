<?php

namespace Tests\Unit\Time;

use App\Time\Duration;
use Tests\TestCase;

class DurationTest extends TestCase
{
    /**
     *@test
     */
    public function a_duration_expressess_a_period_of_minutes_as_a_readable_string()
    {
        $cases = [
            [
                'mins' => 120,
                'expects' => '2 小時'
            ],
            [
                'mins' => 30,
                'expects' => '30 分鐘'
            ],
            [
                'mins' => 150,
                'expects' => '2 小時 30 分鐘'
            ],
            [
                'mins' => 90,
                'expects' => '1 小時 30 分鐘'
            ],
            [
                'mins' => 60,
                'expects' => '1 小時'
            ],
        ];
        collect($cases)->each(function($case) {
            $duration = new Duration($case['mins']);
            $this->assertEquals($case['expects'], $duration->asString());
            $this->assertEquals($case['mins'], $duration->minutes());
        });
    }

    /**
     *@test
     */
    public function can_be_made_from_times()
    {
        $duration = Duration::fromTimes('10:00', '12:00');

        $this->assertEquals(120, $duration->minutes());
    }
}