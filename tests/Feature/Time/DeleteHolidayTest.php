<?php


namespace Tests\Unit\Time;


use App\Time\Holiday;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DeleteHolidayTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_holiday_may_be_deleted()
    {
        $this->withoutExceptionHandling();
        $today = Carbon::today();
        $holiday = Holiday::create([
            'year' => $today->year,
            'month' => $today->month,
            'day' => $today->day,
            'name' => 'test name'
        ]);

        $response = $this->asManager()->deleteJson("/admin/holidays/{$holiday->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('holidays', ['id' => $holiday->id]);
    }

    /**
     *@test
     */
    public function a_holiday_can_only_be_deleted_by_a_manager()
    {
        $today = Carbon::today();
        $holiday = Holiday::create([
            'year' => $today->year,
            'month' => $today->month,
            'day' => $today->day,
            'name' => 'test name'
        ]);

        $response = $this->asStaff()->deleteJson("/admin/holidays/{$holiday->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('holidays', ['id' => $holiday->id]);
    }
}