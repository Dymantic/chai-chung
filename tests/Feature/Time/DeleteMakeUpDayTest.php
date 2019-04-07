<?php


namespace Tests\Feature\Time;


use App\Time\MakeUpDay;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DeleteMakeUpDayTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_make_up_day_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $make_up_day = MakeUpDay::forDate(Carbon::today()->format('Y-m-d'), 'test reason');

        $response = $this->asManager()->deleteJson("/admin/make-up-days/{$make_up_day->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('make_up_days', ['id' => $make_up_day->id]);
    }

    /**
     *@test
     */
    public function a_make_up_day_can_only_be_deleted_by_a_manager()
    {
        $make_up_day = MakeUpDay::forDate(Carbon::today()->format('Y-m-d'), 'test reason');

        $response = $this->asStaff()->deleteJson("/admin/make-up-days/{$make_up_day->id}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('make_up_days', ['id' => $make_up_day->id]);
    }
}