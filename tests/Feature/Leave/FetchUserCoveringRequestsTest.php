<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchUserCoveringRequestsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_requests_for_a_user_to_cover_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $staff = factory(User::class)->create();
        $other_staff = factory(User::class)->create();

        $needsCoverA = $this->makeLeaveRequest($staff, LeaveRequest::SUBMITTED, Carbon::parse('next tuesday'));
        $needsCoverB = $this->makeLeaveRequest($staff, LeaveRequest::SUBMITTED, Carbon::parse('next friday'));
        $alreadyCovered = $this->makeLeaveRequest($staff, LeaveRequest::COVERED, Carbon::parse('next tuesday'));
        $rejected = $this->makeLeaveRequest($staff, LeaveRequest::COVER_REJECTED, Carbon::parse('next tuesday'));
        $accepted = $this->makeLeaveRequest($staff, LeaveRequest::ACCEPTED, Carbon::parse('next tuesday'));
        $denied = $this->makeLeaveRequest($staff, LeaveRequest::DENIED, Carbon::parse('next tuesday'));
        $cancelled = $this->makeLeaveRequest($staff, LeaveRequest::CANCELLED, Carbon::parse('next tuesday'));
        $date_passed = $this->makeLeaveRequest($staff, LeaveRequest::SUBMITTED, Carbon::parse('last tuesday'));
        $other_user = $this->makeLeaveRequest($other_staff, LeaveRequest::SUBMITTED, Carbon::parse('next tuesday'));

        $response = $this->actingAs($staff)->getJson("/admin/user-covering-requests");
        $response->assertStatus(200);

        $fetched_requests = collect($response->decodeResponseJson());

        $this->assertCount(2, $fetched_requests);

        $this->assertContains($needsCoverA->id, $fetched_requests->pluck('id')->all());
        $this->assertContains($needsCoverB->id, $fetched_requests->pluck('id')->all());

        $this->assertNotContains($alreadyCovered->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($rejected->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($accepted->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($denied->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($cancelled->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($date_passed->id, $fetched_requests->pluck('id')->all());
        $this->assertNotContains($other_user->id, $fetched_requests->pluck('id')->all());
    }

    private function makeLeaveRequest($coverer, $status, $date)
    {
        return factory(LeaveRequest::class)->create([
            'starts' => $date->setHours(8)->setMinutes(0),
            'ends' => $date->setHours(17)->setMinutes(0),
            'covering_user_id' => $coverer->id,
            'status' => $status
        ]);
    }
}