<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\Notifications\CoverWasAccepted;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyOfCoverAcceptedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function notifies_requestee_when_cover_is_accepted()
    {
        Notification::fake();

        $this->withoutExceptionHandling();

        $staffA = factory(User::class)->create();
        $staffB = factory(User::class)->create();
        $leave_request = factory(LeaveRequest::class)->create([
            'user_id' => $staffA->id,
            'covering_user_id' => $staffB->id
        ]);

        $response = $this
            ->actingAs($staffB)
            ->postJson("/admin/covered-leave-requests", [
                'leave_request_id' => $leave_request->id
            ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $staffA,
            CoverWasAccepted::class,
            function ($notification) use ($staffB) {
                return $notification->leave_request_info['covered_by'] === $staffB->name;
            });
    }
}