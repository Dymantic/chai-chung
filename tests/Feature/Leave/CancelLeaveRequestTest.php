<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_existing_leave_request_may_be_canceled()
    {
        $this->withoutExceptionHandling();

        $staff = factory(User::class)->create();
        $leave_request = factory(LeaveRequest::class)->create(['user_id' => $staff]);

        $response = $this->actingAs($staff)->postJson("/admin/cancelled-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => LeaveRequest::CANCELLED
        ]);
    }

    /**
     *@test
     */
    public function a_leave_request_can_only_be_cancelled_by_its_owner()
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();
        $leave_request = factory(LeaveRequest::class)->create(['user_id' => $staffA]);

        $response = $this->actingAs($staffB)->postJson("/admin/cancelled-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => LeaveRequest::SUBMITTED
        ]);
    }
}