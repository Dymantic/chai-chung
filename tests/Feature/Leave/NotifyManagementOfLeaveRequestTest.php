<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\RequestForLeave;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyManagementOfLeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function notifies_management_one_cover_accepted()
    {
        Notification::fake();

        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();
        $manager = factory(User::class)->create(['is_manager' => true]);
        $leave_request = factory(LeaveRequest::class)->create([
            'user_id'          => $staffA->id,
            'covering_user_id' => $staffB->id,
            'status'           => LeaveRequest::SUBMITTED
        ]);

        $response = $this->actingAs($staffB)->postJson("/admin/covered-leave-requests", [
            'leave_request_id' => $leave_request->id
        ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $manager,
            RequestForLeave::class,
            function ($notification) use ($staffB) {
                return $notification->leave_request_info['covered_by'] === $staffB->name;
            });
    }
}