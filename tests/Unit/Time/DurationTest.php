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
                'expects' => '2 hrs'
            ],
            [
                'mins' => 30,
                'expects' => '30 mins'
            ],
            [
                'mins' => 150,
                'expects' => '2 hrs 30 mins'
            ],
            [
                'mins' => 90,
                'expects' => '1 hrs 30 mins'
            ],
            [
                'mins' => 60,
                'expects' => '1 hrs'
            ],
        ];
        collect($cases)->each(function($case) {
            $duration = new Duration($case['mins']);
            $this->assertEquals($case['expects'], $duration->asString());
        });
    }
}