<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCoverRejectedLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_covering_user_may_decline_to_cover_a_leave_request()
    {
        $this->withoutExceptionHandling();

        $staff = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'covering_user_id' => $staff
        ]);

        $response = $this->actingAs($staff)->postJson("/admin/cover-rejected-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'cover_rejected'
        ]);
    }

    /**
     *@test
     */
    public function the_cover_can_only_be_rejected_by_the_covering_user()
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'covering_user_id' => $staffA
        ]);

        $response = $this->actingAs($staffB)->postJson("/admin/cover-rejected-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => 'submitted'
        ]);
    }
}