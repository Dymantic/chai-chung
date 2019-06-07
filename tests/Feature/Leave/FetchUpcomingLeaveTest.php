<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchUpcomingLeaveTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetches_upcoming_leave_that_has_been_approved()
    {
        $this->withoutExceptionHandling();

        $manager = factory(User::class)->create(['is_manager' => true]);
        $upcoming_and_approved = collect([5,12,30])->map(function($days) use ($manager) {
            $leave_request =  $this->makeLeaveDay(Carbon::today()->addDays($days), 'accepted');
            $leave_request->acceptBy($manager);

            return $leave_request;
        });
        $passed = $this->makeLeaveDay(Carbon::today()->subDays(5), 'accepted');
        $not_approved = $this->makeLeaveDay(Carbon::today()->addDays(5), 'submitted');

        $response = $this->asManager()->getJson("/admin/upcoming-leave");
        $response->assertStatus(200);

        $fetched_requests = $response->decodeResponseJson();

        $this->assertCount(3, $fetched_requests);

        collect($fetched_requests)->each(function($fetched_request) use ($upcoming_and_approved) {
            $this->assertContains($fetched_request['id'], $upcoming_and_approved->pluck('id')->values());
        });
    }

    /**
     *@test
     */
    public function upcoming_leave_for_all_users_can_only_be_fetched_by_a_manager()
    {
        $response = $this->asStaff()->getJson("/admin/upcoming-leave");
        $response->assertStatus(403);
    }

    private function makeLeaveDay($date, $status)
    {
        return factory(LeaveRequest::class)->create([
            'starts' => $date->setHours(8)->setMinutes(30),
            'ends' => $date->setHours(17)->setMinutes(30),
            'status' => $status
        ]);
    }
}