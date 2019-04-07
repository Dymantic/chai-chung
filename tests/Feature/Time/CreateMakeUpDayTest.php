<?php


namespace Tests\Feature\Time;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateMakeUpDayTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_make_up_day_can_be_created()
    {
        $this->withoutExceptionHandling();
        $today = Carbon::today();

        $response = $this->asManager()->postJson("/admin/make-up-days", [
            'date' => $today->format('Y-m-d'),
            'reason' => 'Test reason'
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('make_up_days', [
            'year' => $today->year,
            'month' => $today->month,
            'day' => $today->day,
            'reason' => 'Test reason'
        ]);
    }

    /**
     *@test
     */
    public function a_make_up_day_can_only_be_added_by_a_manager()
    {
        $today = Carbon::today();

        $response = $this->asStaff()->postJson("/admin/make-up-days", [
            'date' => $today->format('Y-m-d'),
            'reason' => 'Test reason'
        ]);
        $response->assertStatus(403);
    }

    /**
     *@test
     */
    public function the_date_is_required()
    {
        $this->assertFieldInvalid(['date' => '']);
    }

    /**
     *@test
     */
    public function the_date_must_be_a_valid_date()
    {
        $this->assertFieldInvalid(['date' => 'not-a-real-date']);
    }

    /**
     *@test
     */
    public function the_reason_is_required()
    {
        $this->assertFieldInvalid(['reason' => '']);
    }

    private function assertFieldInvalid($field)
    {
        $today = Carbon::today();
        $valid = ['date' => $today->format('Y-m-d'), 'reason' => 'test reason'];

        $response = $this->asManager()->postJson("/admin/make-up-days", array_merge($valid, $field));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}