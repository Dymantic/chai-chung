<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDeniedLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_leave_request_may_be_denied()
    {
        $this->withoutExceptionHandling();

        $leave_request = factory(LeaveRequest::class)->create(['status' => 'covered']);

        $response = $this->asManager()->postJson("/admin/denied-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => LeaveRequest::DENIED
        ]);
    }

    /**
     *@test
     */
    public function a_leave_request_can_only_be_denied_by_a_manager()
    {
        $leave_request = factory(LeaveRequest::class)->create(['status' => LeaveRequest::COVERED]);

        $response = $this->asStaff()->postJson("/admin/denied-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => LeaveRequest::COVERED
        ]);
    }
}