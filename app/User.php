<?php

namespace App;

use App\Leave\LeaveRequest;
use App\Time\Session;
use App\Time\WorkDay;
use Carbon\CarbonPeriod;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable, Pastureable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_manager',
        'user_code',
        'hourly_rate'
    ];

    protected $dates = ['pastured_on'];

    protected $casts = ['is_manager' => 'bool'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function scopeManagers($query)
    {
        return $query->where('is_manager', true);
    }

    public function promote()
    {
        $this->is_manager = true;
        $this->save();
    }

    public function demote()
    {
        $this->is_manager = false;
        $this->save();
    }

    public function setPassword($new_password)
    {
        $this->password = bcrypt($new_password);
        $this->save();
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function addSession($session_data)
    {

        $session = $this->sessions()->create($session_data);

        return $session;
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function createLeaveRequest($input)
    {
        return $this->leaveRequests()->create($input);
    }

    public function covering()
    {
        return $this->hasMany(LeaveRequest::class, 'covering_user_id');
    }

    public function agreedToCover()
    {
        return $this->covering()
                    ->where('ends', '>=', Carbon::now()->subDays(5))
                    ->whereIn('status', [LeaveRequest::ACCEPTED, LeaveRequest::COVERED])
                    ->get();
    }

    public function workDay($date)
    {
        $start_of_day = Carbon::parse($date)->startOfDay();
        $end_of_day = Carbon::parse($date)->endOfDay();
        $sessions = $this
            ->sessions()
            ->whereBetween('start_time', [$start_of_day, $end_of_day])
            ->orderBy('start_time')
            ->get();
        return new WorkDay($sessions);
    }

    public function costReport($start, $end)
    {
        $hrs = 0;
        $overtime = 0;
        $cost = 0;


        foreach(CarbonPeriod::create($start, $end) as $day) {
            $workDay = $this->workDay($day);
            $hrs = $hrs + $workDay->totalHours();
            $overtime = $overtime + $workDay->totalOvertime();
            $cost = $cost + $workDay->costOfDay($this->hourly_rate);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'total_hours' => $hrs,
            'overtime_hours' => $overtime,
            'hourly_rate' => $this->hourly_rate,
            'cost' => $cost,
        ];
    }


}
