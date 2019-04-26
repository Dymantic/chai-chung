<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\CoverWasRejected;
use App\Notifications\LeaveRequestAccepted;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyOfLeaveRequestApprovedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function notifies_requestee_when_request_is_approved()
    {
        Notification::fake();

        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
            'status'  => LeaveRequest::COVERED
        ]);

        $response = $this
            ->asManager()
            ->postJson("/admin/accepted-leave-requests", [
                'leave_request_id' => $leave_request->id
            ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $staffA,
            LeaveRequestAccepted::class,
            function ($notification) {
                return ($notification->leave_request_info['decided_on'] === Carbon::today()->format('Y-m-d')) && ($notification->leave_request_info['status'] === LeaveRequest::ACCEPTED);
            });
    }
}