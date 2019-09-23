<?php

namespace App\Leave;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LeaveRequest extends Model
{
    const SUBMITTED = 'submitted';
    const COVERED = 'covered';
    const COVER_REJECTED = 'cover_rejected';
    const ACCEPTED = 'accepted';
    const DENIED = 'denied';
    const CANCELLED = 'cancelled';

    protected $fillable = ['starts', 'ends', 'status', 'reason', 'covering_user_id', 'leave_type'];

    protected $dates = ['starts', 'ends', 'decided_on'];


    public function scopeUndecided($query)
    {
        return $query
            ->where('status', static::COVERED);
    }

    public function scopeUpcomingGranted($query)
    {
        return $query
            ->where('ends', '>=', Carbon::now())
            ->where('status', static::ACCEPTED);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function needsCoverBy(User $user)
    {
        return static::where('covering_user_id', $user->id)
                     ->where('status', static::SUBMITTED);
    }

    public function covered_by()
    {
        return $this->belongsTo(User::class, 'covering_user_id');
    }

    public function decider()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }

    public function cover()
    {
        $this->status = static::COVERED;
        $this->save();
    }

    public function cancel()
    {
        $this->status = static::CANCELLED;
        $this->save();
    }

    public function updateCoveringUser(User $user)
    {
        $this->covering_user_id = $user->id;
        $this->status = static::SUBMITTED;
        $this->save();
    }

    public function rejectCover()
    {
        $this->status = static::COVER_REJECTED;
        $this->save();
    }

    public function acceptBy($manager)
    {
        $this->status = static::ACCEPTED;
        $this->decided_by = $manager->id;
        $this->decided_on = Carbon::now();
        $this->save();
    }

    public function denyBy($manager)
    {
        $this->status = static::DENIED;
        $this->decided_by = $manager->id;
        $this->decided_on = Carbon::now();
        $this->save();
    }

    public function statusText()
    {
        if ($this->status === static::ACCEPTED) {
            return '批准';
        }

        if ($this->status === static::DENIED) {
            return '拒絕';
        }

        if ($this->status === static::CANCELLED) {
            return '取消';
        }

        return '尚未決定';
    }

    public function toArray()
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user->id,
            'requestee'        => $this->user->name,
            'covering_user_id' => $this->covered_by->id,
            'covered_by'       => $this->covered_by->name,
            'starts_date'      => $this->starts->format('Y-m-d'),
            'starts_time'      => $this->starts->format('H:i'),
            'starts_day'       => $this->starts->format('D'),
            'ends_date'        => $this->ends->format('Y-m-d'),
            'ends_time'        => $this->ends->format('H:i'),
            'ends_day'         => $this->ends->format('D'),
            'reason'           => $this->reason,
            'status'           => $this->status,
            'status_summary'      => $this->statusText(),
            'was_cancelled'    => $this->status === static::CANCELLED,
            'decider'          => $this->decider ? $this->decider->name : '',
            'decided_on'       => $this->decided_on ? $this->decided_on->format('Y-m-d') : '',
            'has_past'         => $this->starts->isPast(),
            'leave_type'       => $this->leave_type,
        ];
    }

    public static function annualSummary($year)
    {
        $start = Carbon::create($year, 1, 1)->startOfDay();
        $end = Carbon::create($year, 12, 31)->endOfDay();

        $records = static::with('user', 'covered_by')
                         ->where('ends', '>', $start)
                         ->where('starts', '<', $end)
                         ->get();

        return [
            'head' => [
                'title'       => 'Staff Leave Records for ' . $year,
                'starts'      => "1/1 {$year}",
                'ends'        => "12/31 {$year}",
                'columns'     => ['代號', '姓名', '開始', '結束', '請假類別', '代班', '狀態', '理由'],
                'report_date' => Carbon::now()->format('m-d-Y'),
            ],
            'data' => $records->map(function ($request) {
                return [
                    $request->user->user_code,
                    $request->user->name,
                    $request->starts->format('m-d-Y, h:i'),
                    $request->ends->format('m-d-Y, h:i'),
                    $request->leave_type,
                    $request->covered_by->name,
                    $request->statusText(),
                    $request->reason,
                ];
            })->all(),
        ];
    }
}
