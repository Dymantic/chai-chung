<?php


namespace Tests\Feature\Leave;


use App\Leave\LeaveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FetchPastLeaveRecordsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_past_requests_for_the_given_year()
    {
        $year = Carbon::now()->year - 1;

        $feb = $this->makeLeaveRequest($year, 2, 4);
        $aprA = $this->makeLeaveRequest($year, 4, 4);
        $aprB = $this->makeLeaveRequest($year, 4, 16);
        $oct = $this->makeLeaveRequest($year, 10, 5);
        $too_old = $this->makeLeaveRequest($year - 1, 2, 4);

        $this->withoutExceptionHandling();

        $response = $this->asManager()->getJson("/admin/past-leave-requests?year={$year}");
        $response->assertStatus(200);

        $fetched = $response->json();

        $this->assertCount(3, $fetched);

        $this->assertCount(1, $fetched['February']);
        $this->assertEquals($feb->toArray(), $fetched['February'][0]);

        $this->assertCount(2, $fetched['April']);
        $this->assertEquals($aprA->toArray(), $fetched['April'][0]);
        $this->assertEquals($aprB->toArray(), $fetched['April'][1]);

        $this->assertCount(1, $fetched['October']);
        $this->assertEquals($oct->toArray(), $fetched['October'][0]);
    }

    private function makeLeaveRequest($year, $month, $day)
    {
        $start = Carbon::create($year, $month, $day, 8, 30);
        return factory(LeaveRequest::class)->create(['starts' => $start, 'ends' => Carbon::parse($start)->addDay()]);
    }
}
