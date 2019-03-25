<?php

namespace Tests\Feature\Sessions;

use App\Clients\EngagementCode;
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

        $session_data = [
            'user_id' => $user->id,
            'session_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => Carbon::now()->subHours(3)->hour . ":30",
            'end_time' => Carbon::now()->subHours(1)->hour . ":30",
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
            'start_time' => Carbon::now()->subHours(3)->startOfHour()->addMinutes(30),
            'end_time' => Carbon::now()->subHours(1)->startOfHour()->addMinutes(30),
            'service_period' => Carbon::today()->year,
            'client_id' => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'description' => 'test description',
            'notes' => 'test notes',
        ]);
    }
}