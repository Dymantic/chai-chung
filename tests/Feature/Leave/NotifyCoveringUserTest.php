<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\RequestForCover;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyCoveringUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function notify_on_request_created()
    {
        Notification::fake();

        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();

        $leave_data = [
            'start_date' => Carbon::today()->format('Y-m-d'),
            'start_time' => '08:00',
            'end_date' => Carbon::today()->addDays(3)->format('Y-m-d'),
            'end_time' => '17:00',
            'covering_user_id' => $staffB->id,
            'reason' => 'test reason'
        ];

        $response = $this->actingAs($staffA)->postJson("/admin/users/{$staffA->id}/leave-requests", $leave_data);
        $response->assertStatus(201);

        Notification::assertSentTo($staffB, RequestForCover::class, function($notification, $channels) use ($staffA) {
            return $notification->leave_request_info['requestee'] === $staffA->name;
        });
    }

    /**
     *@test
     */
    public function notify_on_coverer_updated()
    {
        Notification::fake();

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

        Notification::assertSentTo($staffB, RequestForCover::class, function($notification, $channels) use ($staffA, $staffB) {
            return ($notification->leave_request_info['requestee'] === $staffA->name) &&
                ($notification->leave_request_info['covered_by'] === $staffB->name);
        });
    }
}