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

    protected $fillable = ['starts', 'ends', 'status', 'reason', 'covering_user_id'];

    protected $dates = ['starts', 'ends', 'decided_on'];


    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function toArray()
    {
        return [
            'user_id' => $this->user->id,
            'requestee' => $this->user->name,
            'covering_user_id' => $this->covered_by->id,
            'covered_by' => $this->covered_by->name,
            'starts' => $this->starts->format('Y-m-d (H:i)'),
            'ends' => $this->ends->format('Y-m-d (H:i)'),
            'reason' => 'test reason',
            'status' => $this->status,
            'decider' => $this->decider ? $this->decider->name : '',
            'decided_on' => $this->decided_on ? $this->decided_on->format('Y-m-d') : ''
        ];
    }
}
