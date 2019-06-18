<?php

namespace Tests\Feature\Sessions;

use App\Clients\EngagementCode;
use App\Time\Holiday;
use App\Time\Session;
use App\User;
use App\Clients\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateSessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_session_can_be_created()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();
        Holiday::setDates([
            'start' => Carbon::parse('last friday'),
            'end' => Carbon::parse('last friday'),
            'name' => 'test holiday'
        ]);

        $session_data = [
            'session_date' => Carbon::parse('last friday')->format('Y-m-d'),
            'start_time' => "10:30",
            'end_time' => "12:30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions", $session_data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('time_sessions', [
            'user_id' => $user->id,
            'start_time' => Carbon::parse('last friday')->setHour(10)->startOfHour()->setMinutes(30),
            'end_time' => Carbon::parse('last friday')->setHour(12)->startOfHour()->setMinutes(30),
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
            'on_holiday' => true,
            'on_make_up_day' => false,
            'overtime_minutes' => 120
        ]);
    }

    /**
     *@test
     */
    public function the_session_date_is_required()
    {
        $this->assertFieldIsInvalid(['session_date' => null]);
    }

    /**
     *@test
     */
    public function the_session_date_must_be_an_actual_date()
    {
        $this->assertFieldIsInvalid(['session_date' => 'not-a-real-date']);
    }

    /**
     *@test
     */
    public function the_start_time_must_follow_the_format_hh_mm_with_only_00_or_30_mins_allowed()
    {
        $invalid_times = collect([
            'not even a time',
            '25:00',
            '-1:00',
            'a:30',
            'a:b',
            '10:12',
        ]);
        $invalid_times->each(function($invalid_time) {
            $this->assertFieldIsInvalid(['start_time' => $invalid_time]);
        });

    }

    /**
     *@test
     */
    public function the_end_time_must_follow_the_format_hh_mm_with_only_00_or_30_mins_allowed()
    {
        $invalid_times = collect([
            'not even a time',
            '25:00',
            '-1:00',
            'a:30',
            'a:b',
            '10:12',
        ]);
        $invalid_times->each(function($invalid_time) {
            $this->assertFieldIsInvalid(['end_time' => $invalid_time]);
        });
    }

    /**
     *@test
     */
    public function the_end_time_must_be_later_than_the_start_time()
    {
        $this->assertFieldIsInvalid(['end_time' => '09:30', 'start_time' => '11:30']);
    }

    /**
     *@test
     */
    public function the_session_duration_cannot_exceed_four_hours()
    {
        $this->assertFieldIsInvalid(['end_time' => '13:00', 'start_time' => '08:30']);
    }

    /**
     *@test
     */
    public function a_session_can_not_be_created_if_previous_four_hours_are_logged()
    {
        $user = factory(User::class)->create();
        factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(8)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(10)->setMinutes(30),
        ]);
        factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(10)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(12)->setMinutes(30),
        ]);

        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();
        $session_data =[
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => "12:30",
            'end_time' => "13:30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions", $session_data);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('start_time');
    }

    /**
     *@test
     */
    public function the_service_period_is_required()
    {
        $this->assertFieldIsInvalid(['service_period' => '']);
    }


    /**
     *@test
     */
    public function the_client_id_must_be_an_existing_client_id()
    {
        $non_existing_id = 99;
        $this->assertNull(Client::find($non_existing_id));

        $this->assertFieldIsInvalid(['client_id' => $non_existing_id]);
    }

    /**
     *@test
     */
    public function the_engagement_code_id_must_be_an_existing_engagement_code_id()
    {
        $non_existing_id = 99;
        $this->assertNull(EngagementCode::find($non_existing_id));

        $this->assertFieldIsInvalid(['engagement_code_id' => $non_existing_id]);
    }

    /**
     *@test
     */
    public function the_description_is_required()
    {
        $this->assertFieldIsInvalid(['description' => '']);
    }

    /**
     *@test
     */
    public function the_notes_are_not_required()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();

        $session_data = [
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => Carbon::now()->subHours(3)->hour . ":30",
            'end_time' => Carbon::now()->subHours(1)->hour . ":30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => '',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions", $session_data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('time_sessions', [
            'user_id' => $user->id,
            'start_time' => Carbon::now()->subHours(3)->startOfHour()->addMinutes(30),
            'end_time' => Carbon::now()->subHours(1)->startOfHour()->addMinutes(30),
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => null,
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();
        $valid =[
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => Carbon::now()->subHours(3)->hour . ":30",
            'end_time' => Carbon::now()->subHours(1)->hour . ":30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions", array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}