<?php

namespace App\Time;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'time_sessions';

    protected $fillable = [
        'user_id',
        'session_date',
        'start_time',
        'end_time',
        'service_period',
        'client_id',
        'engagement_code_id',
        'description',
        'notes',
    ];

    public function duration()
    {
        return $this->end_time->diffInMinutes($this->start_time);
    }
}
