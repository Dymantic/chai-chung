<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\LeaveRequestAccepted;
use App\Notifications\LeaveRequestCancelled;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyOfLeaveRequestCancelledTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function management_is_notified_when_a_leave_request_is_cancelled()
    {
        Notification::fake();

        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $manager = factory(User::class)->create(['is_manager' => true]);

        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
        ]);

        $response = $this
            ->actingAs($staffA)
            ->postJson("/admin/cancelled-leave-requests", [
                'leave_request_id' => $leave_request->id
            ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $manager,
            LeaveRequestCancelled::class,
            function ($notification) use ($staffA) {
                return ($notification->leave_request_info['requestee'] === $staffA->name) && ($notification->leave_request_info['status'] === LeaveRequest::CANCELLED);
            });
    }
}