<?php


namespace Tests\Unit\Time;


use App\Clients\Client;
use App\Clients\EngagementCode;
use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SessionPresentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_sessions_gets_presented_for_a_user_manager_status()
    {
        $manager = factory(User::class)->create(['is_manager' => true]);
        $staff = factory(User::class)->create(['is_manager' => false, 'hourly_rate' => 500]);
        $client = factory(Client::class)->create();
        $engagement_code = factory(EngagementCode::class)->create();

        $session = factory(Session::class)->create([
            'user_id'            => $staff,
            'client_id'          => $client->id,
            'engagement_code_id' => $engagement_code->id,
            'start_time'         => Carbon::today()->setHour(10)->setMinutes(0),
            'end_time'           => Carbon::today()->setHour(12)->setMinutes(0),
        ]);

        $session->overtime_set_by = $manager->id;
        $session->manual_overtime = 120;
        $session->manual_overtime_reason = 'test overtime reason';
        $session->save();
        $session = $session->fresh();

        $expected_for_staff = [
            'id'                          => $session->id,
            'date'                        => Carbon::today()->format('m/d Y'),
            'date_comp'                   => Carbon::today()->format('Ymd'),
            'start_time'                  => "10:00",
            'end_time'                    => "12:00",
            'service_period'              => $session->service_period,
            'client_id'                   => $client->id,
            'client_code'                 => $client->client_code,
            'client_name'                 => $client->name,
            'engagement_code_id'          => $engagement_code->id,
            'engagement_code'             => $engagement_code->code,
            'engagement_code_description' => $engagement_code->description,
            'description'                 => $session->description,
            'notes'                       => $session->notes,
            'duration'                    => "2 hrs"
        ];

        $expected_for_manager = [
            'id'                          => $session->id,
            'date'                        => Carbon::today()->format('m/d Y'),
            'date_comp'                   => Carbon::today()->format('Ymd'),
            'start_time'                  => "10:00",
            'end_time'                    => "12:00",
            'service_period'              => $session->service_period,
            'client_id'                   => $client->id,
            'client_code'                 => $client->client_code,
            'client_name'                 => $client->name,
            'engagement_code_id'          => $engagement_code->id,
            'engagement_code'             => $engagement_code->code,
            'engagement_code_description' => $engagement_code->description,
            'description'                 => $session->description,
            'notes'                       => $session->notes,
            'duration'                    => "2 hrs",
            'overtime'                    => 120,
            'overtime_set_by'             => $manager->name,
            'overtime_reason'             => 'test overtime reason',
            'cost'                        => 1000
        ];

        $this->assertEquals($expected_for_staff, $session->presentFor($staff));
        $this->assertEquals($expected_for_manager, $session->presentFor($manager));

    }
}