<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchUndecidedRequestsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_covered_undecided_upcoming_leave_requests()
    {
        $this->withoutExceptionHandling();

        $upcomingA = $this->makeLeaveRequest(LeaveRequest::COVERED, Carbon::parse('next monday'));
        $upcomingB = $this->makeLeaveRequest(LeaveRequest::COVERED, Carbon::parse('next monday'));
        $uncovered = $this->makeLeaveRequest(LeaveRequest::SUBMITTED, Carbon::parse('next monday'));
        $rejected = $this->makeLeaveRequest(LeaveRequest::COVER_REJECTED, Carbon::parse('next monday'));
        $accepted = $this->makeLeaveRequest(LeaveRequest::ACCEPTED, Carbon::parse('next monday'));
        $denied = $this->makeLeaveRequest(LeaveRequest::DENIED, Carbon::parse('next monday'));
        $cancelled = $this->makeLeaveRequest(LeaveRequest::CANCELLED, Carbon::parse('next monday'));
        $old = $this->makeLeaveRequest(LeaveRequest::COVERED, Carbon::parse('last monday'));

        $response = $this->asManager()->getJson("/admin/staff-leave-requests");
        $response->assertStatus(200);

        $fetched_requests = collect($response->decodeResponseJson());

        $this->assertCount(3, $fetched_requests);

        $this->assertContains($upcomingA->id, $fetched_requests->pluck('id')->all());
        $this->assertContains($upcomingB->id, $fetched_requests->pluck('id')->all());

        $this->assertNotContains($uncovered->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($rejected->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($accepted->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($denied->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($cancelled->id, $fetched_requests->pluck('id')->all());
        $this->assertContains($old->id, $fetched_requests->pluck('id')->all());
    }

    /**
     *@test
     */
    public function the_undecided_requests_can_only_be_fetched_by_manager()
    {
        $response = $this->asStaff()->getJson("/admin/staff-leave-requests");
        $response->assertStatus(403);
    }

    private function makeLeaveRequest($status, $date)
    {
        return factory(LeaveRequest::class)->create([
            'starts' => $date->setHours(8)->setMinutes(0),
            'ends' => $date->setHours(17)->setMinutes(0),
            'status' => $status
        ]);
    }
}