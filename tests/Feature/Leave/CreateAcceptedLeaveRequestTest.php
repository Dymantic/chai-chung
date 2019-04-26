<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAcceptedLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_leave_request_can_be_accepted()
    {
        $this->withoutExceptionHandling();

        $leave_request = factory(LeaveRequest::class)->create(['status' => 'covered']);

        $response = $this->asManager()->postJson("/admin/accepted-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'accepted'
        ]);
    }

    /**
     *@test
     */
    public function a_leave_request_can_only_be_accepted_by_a_manager()
    {
        $leave_request = factory(LeaveRequest::class)->create(['status' => 'covered']);

        $response = $this->asStaff()->postJson("/admin/accepted-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'covered'
        ]);
    }
}