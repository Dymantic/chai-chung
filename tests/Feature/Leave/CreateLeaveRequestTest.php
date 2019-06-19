<?php

namespace Tests\Feature\Leave;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_request_for_leave_may_be_created()
    {
        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $leave_data = [
            'start_date'       => Carbon::today()->format('Y-m-d'),
            'start_time'       => '08:00',
            'end_date'         => Carbon::today()->addDays(3)->format('Y-m-d'),
            'end_time'         => '17:00',
            'covering_user_id' => $staffB->id,
            'reason'           => 'test reason',
            'leave_type'       => '事假'
        ];

        $response = $this->actingAs($staffA)->postJson("/admin/leave-requests", $leave_data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('leave_requests', [
            'user_id'          => $staffA->id,
            'starts'           => Carbon::today()->setHour(8)->setMinutes(0),
            'ends'             => Carbon::today()->addDays(3)->setHour(17)->setMinutes(0),
            'reason'           => 'test reason',
            'covering_user_id' => $staffB->id,
            'status'           => 'submitted',
            'leave_type'       => '事假'
        ]);
    }

    /**
     * @test
     */
    public function the_start_date_is_required()
    {
        $this->assertFieldInvalid(['start_date' => '']);
    }

    /**
     * @test
     */
    public function the_start_date_must_be_a_valid_date()
    {
        $this->assertFieldInvalid(['start_date' => 'not-a-valid-date']);
    }

    /**
     * @test
     */
    public function the_start_time_is_required()
    {
        $this->assertFieldInvalid(['start_time' => '']);
    }

    /**
     * @test
     */
    public function the_start_time_must_be_a_valid_business_time()
    {
        $invalid_times = [
            '01:00',
            '99:00',
            '10:61',
            '11:60',
            '21:00',
            'aa:bb',
            '113:20',
            '11:103'
        ];

        collect($invalid_times)->each(function ($time) {
            $this->assertFieldInvalid(['start_time' => $time]);
        });
    }

    /**
     * @test
     */
    public function the_end_date_is_required()
    {
        $this->assertFieldInvalid(['end_date' => '']);
    }

    /**
     * @test
     */
    public function the_end_date_must_be_a_valid_date()
    {
        $this->assertFieldInvalid(['end_date' => 'not a valid date']);
    }

    /**
     * @test
     */
    public function the_end_date_must_not_be_before_the_start_date()
    {
        $this->assertFieldInvalid(['end_date' => Carbon::today()->subDays(1)->format('Y-m-d')]);
    }

    /**
     * @test
     */
    public function the_end_time_is_required()
    {
        $this->assertFieldInvalid(['end_time' => '']);
    }

    /**
     * @test
     */
    public function the_end_time_must_be_a_valid_business_time_of_day()
    {
        $invalid_times = [
            '01:00',
            '99:00',
            '10:61',
            '11:60',
            '21:00',
            'aa:bb',
            '113:20',
            '11:103'
        ];

        collect($invalid_times)->each(function ($time) {
            $this->assertFieldInvalid(['end_time' => $time]);
        });
    }

    /**
     * @test
     */
    public function the_covering_user_id_is_required()
    {
        $this->assertFieldInvalid(['covering_user_id' => null]);
    }

    /**
     * @test
     */
    public function the_covering_user_id_must_be_an_existing_user_id()
    {
        $this->assertFieldInvalid(['covering_user_id' => 99]);
    }

    /**
     * @test
     */
    public function the_leave_type_must_be_a_valid_type()
    {
        $this->assertFieldInvalid(['leave_type' => 'not-a-valid-reason']);
    }

    private function assertFieldInvalid($field)
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $valid = [
            'start_date'       => Carbon::today()->format('Y-m-d'),
            'start_time'       => '08:00',
            'end_date'         => Carbon::today()->addDays(3)->format('Y-m-d'),
            'end_time'         => '17:00',
            'covering_user_id' => $staffB->id,
            'reason'           => 'test reason',
            'leave_type'       => '事假'
        ];

        $response = $this->actingAs($staffA)->postJson("/admin/leave-requests",
            array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}