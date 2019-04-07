<?php

namespace Tests\Feature\Time;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateHolidaysTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_holiday_may_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->asManager()->postJson("/admin/holidays", [
            'start_date' => '2019-05-20',
            'end_date' => '2019-05-20',
            'name' => 'birthday'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('holidays', [
            'year' => 2019,
            'month' => 5,
            'day' => 20,
            'name' => 'birthday'
        ]);
    }

    /**
     *@test
     */
    public function holidays_may_only_be_set_by_a_manager()
    {
        $response = $this->asStaff()->postJson("/admin/holidays", [
            'start_date' => '2019-05-20',
            'end_date' => '2019-05-20',
            'name' => 'birthday'
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseMissing('holidays', [
            'year' => 2019,
            'month' => 5,
            'day' => 20,
            'name' => 'birthday'
        ]);
    }

    /**
     *@test
     */
    public function the_start_date_is_required()
    {
        $this->assertFieldsInvalid(['start_date' => '']);
    }

    /**
     *@test
     */
    public function the_start_date_must_be_a_valid_date()
    {
        $this->assertFieldsInvalid(['start_date' => 'not a real date']);
    }

    /**
     *@test
     */
    public function the_end_date_is_required()
    {
        $this->assertFieldsInvalid(['end_date' => '']);
    }

    /**
     *@test
     */
    public function the_end_date_must_be_a_valid_date()
    {
        $this->assertFieldsInvalid(['end_date' => 'not a valid date']);
    }

    /**
     *@test
     */
    public function the_end_date_can_not_be_before_the_start_date()
    {
        $this->assertFieldsInvalid(['end_date' => Carbon::today()->subDay()]);
    }

    private function assertFieldsInvalid($field)
    {
        $valid = [
            'start_date' => Carbon::today()->format('Y-m-d'),
            'end_date' => Carbon::today()->format('Y-m-d'),
            'name' => 'Test holiday'
        ];

        $response = $this->asManager()->postJson("/admin/holidays", array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}