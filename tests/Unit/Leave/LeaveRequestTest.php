<?php


namespace Tests\Unit\Leave;


use App\Leave\LeaveRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaveRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_leave_request_may_be_covered()
    {
        $leave_request = factory(LeaveRequest::class)->create();

        $this->assertEquals('submitted', $leave_request->status);

        $leave_request->cover();

        $this->assertEquals('covered', $leave_request->fresh()->status);
    }

    /**
     * @test
     */
    public function cover_may_be_rejected()
    {
        $leave_request = factory(LeaveRequest::class)->create();

        $this->assertEquals('submitted', $leave_request->status);

        $leave_request->rejectCover();

        $this->assertEquals('cover_rejected', $leave_request->fresh()->status);
    }

    /**
     * @test
     */
    public function a_leave_request_may_be_accepted()
    {
        $leave_request = factory(LeaveRequest::class)->create(['status' => 'covered']);
        $manager = factory(User::class)->create(['is_manager' => true]);

        $this->assertEquals('covered', $leave_request->status);

        $leave_request->acceptBy($manager);

        $this->assertEquals('accepted', $leave_request->fresh()->status);
        $this->assertEquals($manager->id, $leave_request->fresh()->decided_by);
        $this->assertTrue($leave_request->fresh()->decided_on->isToday());
    }

    /**
     * @test
     */
    public function a_leave_request_can_be_denied()
    {
        $leave_request = factory(LeaveRequest::class)->create(['status' => 'covered']);
        $manager = factory(User::class)->create(['is_manager' => true]);

        $this->assertEquals(LeaveRequest::COVERED, $leave_request->status);

        $leave_request->denyBy($manager);

        $this->assertEquals(LeaveRequest::DENIED, $leave_request->fresh()->status);
        $this->assertEquals($manager->id, $leave_request->fresh()->decided_by);
        $this->assertTrue($leave_request->fresh()->decided_on->isToday());
    }

    /**
     * @test
     */
    public function update_covering_user()
    {
        $coverer = factory(User::class)->create();
        $leave_request = factory(LeaveRequest::class)->create(['status' => 'cover_rejected']);

        $leave_request->updateCoveringUser($coverer);

        $this->assertTrue($leave_request->fresh()->covered_by->is($coverer));
        $this->assertEquals(LeaveRequest::SUBMITTED, $leave_request->fresh()->status);
    }

    /**
     * @test
     */
    public function cancel_leave_request()
    {
        $leave_request = factory(LeaveRequest::class)->create();

        $this->assertEquals(LeaveRequest::SUBMITTED, $leave_request->status);

        $leave_request->cancel();

        $this->assertEquals(LeaveRequest::CANCELLED, $leave_request->fresh()->status);
    }

    /**
     * @test
     */
    public function presents_as_array()
    {
        $staff = factory(User::class)->create();
        $covering = factory(User::class)->create();
        $manager = factory(User::class)->create(['is_manager' => true]);

        $starts = Carbon::parse('next monday')->setHour(8)->setMinutes(0);
        $ends = Carbon::parse('next monday')->setHour(17)->setMinutes(0);

        $leave_request = factory(LeaveRequest::class)->create([
            'user_id'          => $staff->id,
            'covering_user_id' => $covering->id,
            'reason'           => 'test reason',
            'starts'           => $starts,
            'ends'             => $ends,
            'status'           => LeaveRequest::ACCEPTED,
            'decided_by'       => $manager->id,
            'decided_on'       => Carbon::today(),
            'leave_type'       => '事假'
        ]);

        $expected = [
            'id'               => $leave_request->id,
            'user_id'          => $staff->id,
            'requestee'        => $staff->name,
            'covering_user_id' => $covering->id,
            'covered_by'       => $covering->name,
            'starts_date'      => $starts->format('Y-m-d'),
            'starts_time'      => $starts->format('H:i'),
            'starts_day'       => $starts->format('D'),
            'ends_date'        => $ends->format('Y-m-d'),
            'ends_time'        => $ends->format('H:i'),
            'ends_day'         => $ends->format('D'),
            'reason'           => 'test reason',
            'status'           => LeaveRequest::ACCEPTED,
            'decider'          => $manager->name,
            'decided_on'       => Carbon::today()->format('Y-m-d'),
            'has_past'         => false,
            'leave_type'       => '事假'
        ];

        $this->assertEquals($expected, $leave_request->toArray());
    }
}