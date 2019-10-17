<?php


namespace Tests\Feature\Sessions;


use App\Clients\Client;
use App\Clients\EngagementCode;
use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateSessionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_a_session()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['is_manager' => false]);
        $old_client = factory(Client::class)->create();
        $new_client = factory(Client::class)->create();
        $old_engagement = factory(EngagementCode::class)->create();
        $new_engagement = factory(EngagementCode::class)->create();

        $session = factory(Session::class)->create([
            'user_id'    => $user->id,
            'client_id' => $old_client->id,
            'engagement_code_id' => $old_engagement->id,
            'start_time' => Carbon::yesterday()->setHours(8)->setMinutes(30),
            'end_time'   => Carbon::yesterday()->setHours(10)->setMinutes(30),
        ]);

        $response = $this->actingAs($user)->postJson("/admin/sessions/{$session->id}", [
            'session_date' => Carbon::yesterday()->subDay()->format('Y-m-d'),
            'start_time' => "10:30",
            'end_time' => "12:30",
            'service_period' => Carbon::today()->year,
            'client_id' => $new_client->id,
            'engagement_code_id' => $new_engagement->id,
            'description' => 'new description',
            'notes' => 'new notes',
        ]);

        $response->assertStatus(200);

        $session = $session->fresh();
        $expected_start = Carbon::yesterday()->subDay()->setHour(10)->setMinutes(30);
        $expected_end = Carbon::yesterday()->subDay()->setHour(12)->setMinutes(30);

        $this->assertEquals($expected_start, $session->start_time);
        $this->assertEquals($expected_end, $session->end_time);
        $this->assertEquals($new_engagement->id, $session->engagement_code->id);
        $this->assertEquals($new_client->id, $session->client->id);
        $this->assertEquals(Carbon::now()->year, $session->service_period);
        $this->assertEquals('new description', $session->description);
        $this->assertEquals('new notes', $session->notes);
    }

    /**
     *@test
     */
    public function a_non_manager_user_cannot_update_another_users_session()
    {
        $staffA = factory(User::class)->state('staff')->create();
        $staffB = factory(User::class)->state('staff')->create();

        $session = factory(Session::class)->create(['user_id' => $staffA]);

        $response = $this->actingAs($staffB)->postJson("/admin/sessions/{$session->id}", [
            'session_date' => Carbon::yesterday()->subDay()->format('Y-m-d'),
            'start_time' => "10:30",
            'end_time' => "12:30",
            'service_period' => Carbon::today()->year,
            'client_id' => $session->client->id,
            'engagement_code_id' => $session->engagement_code->id,
            'description' => 'new description',
            'notes' => 'new notes',
        ]);
        $response->assertStatus(403);
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
    public function cannot_update_if_it_results_in_more_than_four_hours_consecutive()
    {
        $user = factory(User::class)->create();
        factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(8)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(10)->setMinutes(30),
        ]);
        $session = factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(10)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(12)->setMinutes(30),
        ]);

        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();
        $session_data =[
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => "10:30",
            'end_time' => "13:30",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions/{$session->id}", $session_data);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors('start_time');
    }

    /**
     *@test
     */
    public function cannot_update_if_results_in_overlapping_times()
    {
        $user = factory(User::class)->create();
        factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(8)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(10)->setMinutes(30),
        ]);
        $session = factory(Session::class)->create([
            'user_id' => $user->id,
            'start_time' => Carbon::today()->setHour(10)->setMinutes(30),
            'end_time' => Carbon::today()->setHour(12)->setMinutes(30),
        ]);


        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();
        $session_data =[
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => "10:00",
            'end_time' => "12:00",
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ];

        $response = $this->actingAs($user)->postJson("/admin/sessions/{$session->id}", $session_data);
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
    public function the_description_is_not_required()
    {
        $this->assertFieldIsValid(['description' => ''], 200);
    }

    /**
     *@test
     */
    public function the_notes_are_not_required()
    {
        $this->assertFieldIsValid(['notes' => ''], 200);
    }

    private function assertFieldIsInvalid($field)
    {
        $user = factory(User::class)->create();
        $session = factory(Session::class)->create(['user_id' => $user->id]);
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

        $response = $this->actingAs($user)->postJson("/admin/sessions/{$session->id}", array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }

    private function assertFieldIsValid($field, $code = 200) {
        $user = factory(User::class)->create();
        $session = factory(Session::class)->create(['user_id' => $user->id]);
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

        $response = $this->actingAs($user)->postJson("/admin/sessions/{$session->id}", array_merge($valid, $field));
        $response->assertStatus($code);

    }
}