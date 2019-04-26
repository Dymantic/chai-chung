<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLeaveRequestCovererTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_coverer_for_the_request_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
            'status' => LeaveRequest::COVER_REJECTED
        ]);

        $response = $this
            ->actingAs($staffA)
            ->postJson("/admin/leave-requests/{$leave_request->id}", [
                'covering_user_id' => $staffB->id
            ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'covering_user_id' => $staffB->id,
            'status' => LeaveRequest::SUBMITTED
        ]);
    }

    /**
     *@test
     */
    public function the_covering_user_can_only_be_updated_by_the_requests_owner()
    {
        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();
        $staffC = factory(User::class)->create();
        $staffD = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
            'covering_user_id' => $staffD->id,
            'status' => LeaveRequest::COVER_REJECTED
        ]);

        $response = $this
            ->actingAs($staffC)
            ->postJson("/admin/leave-requests/{$leave_request->id}", [
                'covering_user_id' => $staffB->id
            ]);
        $response->assertStatus(403);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'covering_user_id' => $staffD->id,
            'status' => LeaveRequest::COVER_REJECTED
        ]);
    }

    /**
     *@test
     */
    public function the_covering_user_id_must_be_for_an_existing_user()
    {
        $staffA = factory(User::class)->create();

        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
            'status' => LeaveRequest::COVER_REJECTED
        ]);

        $response = $this
            ->actingAs($staffA)
            ->postJson("/admin/leave-requests/{$leave_request->id}", [
                'covering_user_id' => 99
            ]);
        $response->assertStatus(422);

        $this->assertDatabaseHas('leave_requests', [
            'id' => $leave_request->id,
            'status' => LeaveRequest::COVER_REJECTED
        ]);
    }
}