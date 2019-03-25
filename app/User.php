<?php

namespace App;

use App\Time\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_manager', 'user_code', 'hourly_rate'
    ];

    protected $casts = ['is_manager' => 'bool'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
        $start = explode(":", $session_data['start_time']);
        $end = explode(":", $session_data['end_time']);

        $start_time = Carbon::parse($session_data['session_date'])->startOfDay()->setHours($start[0])->setMinutes($start[1]);
        $end_time = Carbon::parse($session_data['session_date'])->startOfDay()->setHours($end[0])->setMinutes($end[1]);
        return $this->sessions()->create([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'client_id' => $session_data['client_id'],
            'engagement_code_id' => $session_data['engagement_code_id'],
            'service_period' => $session_data['service_period'],
            'notes' => $session_data['notes'],
            'description' => $session_data['description'],
        ]);
    }
}
