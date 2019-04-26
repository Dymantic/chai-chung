<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\LeaveRequestAccepted;
use App\Notifications\LeaveRequestDenied;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyOfLeaveRequestDeniedTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function notifies_requestee_when_request_is_denied()
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
            ->postJson("/admin/denied-leave-requests", [
                'leave_request_id' => $leave_request->id
            ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $staffA,
            LeaveRequestDenied::class,
            function ($notification) {
                return ($notification->leave_request_info['decided_on'] === Carbon::today()->format('Y-m-d')) && ($notification->leave_request_info['status'] === LeaveRequest::DENIED);
            });
    }
}