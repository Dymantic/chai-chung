<?php


namespace Tests\Unit\Time;


use App\Time\Holiday;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HolidaysTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function holidays_can_be_created_from_a_range()
    {
        $start = Carbon::today()->addDays(5);
        $day_two = Carbon::today()->addDays(6);
        $day_three = Carbon::today()->addDays(7);
        $end = Carbon::today()->addDays(8);
        $holiday = [
            'start' => $start,
            'end'   => $end,
            'name'  => 'Test holiday'
        ];

        Holiday::setDates($holiday);

        $this->assertDatabaseHas('holidays', [
            'year'  => $start->year,
            'month' => $start->month,
            'day'   => $start->day,
            'name'  => 'Test holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'year'  => $day_two->year,
            'month' => $day_two->month,
            'day'   => $day_two->day,
            'name'  => 'Test holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'year'  => $day_three->year,
            'month' => $day_three->month,
            'day'   => $day_three->day,
            'name'  => 'Test holiday'
        ]);

        $this->assertDatabaseHas('holidays', [
            'year'  => $start->year,
            'month' => $start->month,
            'day'   => $start->day,
            'name'  => 'Test holiday'
        ]);
    }
}