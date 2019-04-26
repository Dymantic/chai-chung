<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCoveredLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_leave_request_can_can_confirmed_as_covered()
    {
        $this->withoutExceptionHandling();

        $staff = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'covering_user_id' => $staff
        ]);

        $response = $this->actingAs($staff)->postJson("/admin/covered-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'covered'
        ]);
    }

    /**
     *@test
     */
    public function the_request_must_come_from_the_covering_user()
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'covering_user_id' => $staffA
        ]);

        $response = $this->actingAs($staffB)->postJson("/admin/covered-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'submitted'
        ]);
    }
}