<?php


namespace Tests\Feature\Sessions;


use App\Time\Session;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OverwriteOvertimeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_overtime_for_a_session_can_be_manually_overwritten()
    {
        $this->withoutExceptionHandling();

        $manager = factory(User::class)->create(['is_manager' => true]);

        $session = $this->makeSession(Carbon::today(), "10:00", "12:00", true);
        $this->assertEquals(120, $session->overtime());

        $response = $this->actingAs($manager)->postJson("/admin/sessions/{$session->id}/overtime", [
            'minutes' => 0,
            'reason'  => 'test reason'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('time_sessions', [
            'id'                     => $session->id,
            'manual_overtime'        => 0,
            'overtime_set_by'        => $manager->id,
            'manual_overtime_reason' => 'test reason'
        ]);

        $this->assertEquals(0, $session->fresh()->overtime());
    }

    /**
     *@test
     */
    public function overtime_can_only_be_overwritten_by_a_manager()
    {

        $session = $this->makeSession(Carbon::today(), "10:00", "12:00", true);
        $this->assertEquals(120, $session->overtime());

        $response = $this->asStaff()->postJson("/admin/sessions/{$session->id}/overtime", [
            'minutes' => 0,
            'reason'  => 'test reason'
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('time_sessions', [
            'id'                     => $session->id,
            'manual_overtime'        => null,
            'overtime_set_by'        => null,
            'manual_overtime_reason' => null
        ]);

        $this->assertEquals(120, $session->fresh()->overtime());
    }

    /**
     *@test
     */
    public function the_minutes_are_required()
    {
        $this->assertFieldInvalid(['minutes' => '']);
    }

    /**
     *@test
     */
    public function the_minutes_must_be_a_valid_integer()
    {
        $this->assertFieldInvalid(['minutes' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_minutes_must_be_positive()
    {
        $this->assertFieldInvalid(['minutes' => -10]);
    }

    /**
     *@test
     */
    public function the_reason_is_required()
    {
        $this->assertFieldInvalid(['reason' => '']);
    }

    private function makeSession($date, $from, $to, $on_holiday = false, $on_make_up_day = false)
    {
        $start_hours = intval(substr($from, 0, 2));
        $start_mins = intval(substr($from, 3, 2));

        $end_hours = intval(substr($to, 0, 2));
        $end_mins = intval(substr($to, 3, 2));

        return factory(Session::class)->create([
            'start_time'     => Carbon::parse($date)->setHours($start_hours)->setMinutes($start_mins),
            'end_time'       => Carbon::parse($date)->setHours($end_hours)->setMinutes($end_mins),
            'on_holiday'     => $on_holiday,
            'on_make_up_day' => $on_make_up_day
        ]);
    }

    private function assertFieldInvalid($field)
    {
        $valid = [
            'minutes' => 60,
            'reason'  => 'test reason'
        ];
        $session = $this->makeSession(Carbon::today(), "10:00", "12:00", true);

        $response = $this->asManager()->postJson("/admin/sessions/{$session->id}/overtime", array_merge($valid, $field));
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(array_keys($field)[0]);
    }
}