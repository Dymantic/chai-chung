<?php

namespace App\Time;

use App\Clients\Client;
use App\Clients\EngagementCode;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Session extends Model
{
    protected $table = 'time_sessions';

    protected $fillable = [
        'session_date',
        'start_time',
        'end_time',
        'service_period',
        'client_id',
        'engagement_code_id',
        'description',
        'notes',
        'on_holiday',
        'on_make_up_day'
    ];

    protected $dates = ['start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function duration()
    {
        $mins = $this->end_time->diffInMinutes($this->start_time);

        return new Duration($mins);
    }

    public function overtime()
    {
        $day_start = Carbon::parse($this->start_time)->setHour(9)->setMinutes(0);
        $day_end = Carbon::parse($this->start_time)->setHour(17)->setMinutes(30);

        if(!is_null($this->manual_overtime)) {
            return $this->manual_overtime;
        }

        if($this->on_holiday) {
            return $this->duration()->minutes();
        }

        if($this->onWeekend() && !$this->on_make_up_day) {
            return $this->duration()->minutes();
        }

        if ($this->duringHours($day_start, $day_end)) {
            return 0;
        }

        if($this->startedBeforeTime($day_start)) {
            return $this->start_time->diffInMinutes($day_start);
        }

        if($this->endedAfterDayEnd($day_end)) {
            return $this->end_time->diffInMinutes($day_end);
        }

        return $this->duration()->minutes();
    }

    private function onWeekend()
    {
        return ($this->start_time->dayOfWeek === 6) || ($this->start_time->dayOfWeek === 7);
    }

    private function duringHours($day_start, $day_end)
    {
        return $this->start_time->greaterThanOrEqualTo($day_start) && $this->end_time->lessThanOrEqualTo($day_end);
    }

    private function startedBeforeTime($day_start)
    {
        return $this->start_time->lessThanOrEqualTo($day_start) && $this->end_time->greaterThanOrEqualTo($day_start);
    }

    private function endedAfterDayEnd($day_end)
    {
        return $this->start_time->lessThanOrEqualTo($day_end) && $this->end_time->greaterThanOrEqualTo($day_end);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function engagement_code()
    {
        return $this->belongsTo(EngagementCode::class);
    }

    public function presentFor($user)
    {
        if(!$user->is_manager) {
            return $this->toArray();
        }

        return [
            'id'                          => $this->id,
            'date'                        => $this->start_time->format('m/d Y'),
            'date_comp'                   => $this->start_time->format('Ymd'),
            'start_time'                  => $this->start_time->format('H:i'),
            'end_time'                    => $this->end_time->format('H:i'),
            'service_period'              => $this->service_period,
            'client_id'                   => $this->client_id,
            'client_code'                 => $this->client->client_code,
            'client_name'                 => $this->client->name,
            'engagement_code_id'          => $this->engagement_code_id,
            'engagement_code'             => $this->engagement_code->code,
            'engagement_code_description' => $this->engagement_code->description,
            'description'                 => $this->description,
            'notes'                       => $this->notes,
            'duration'                    => $this->duration()->asString(),
            'overtime'                    => $this->overtime(),
            'overtime_set_by'             => $this->overtime_set_by ? User::find($this->overtime_set_by)->name : null,
            'overtime_reason'             => $this->manual_overtime_reason,
            'cost'                        => $this->user->hourly_rate * ($this->duration()->minutes() / 60)
        ];
    }

    public function toArray()
    {
        return [
            'id'                          => $this->id,
            'date'                        => $this->start_time->format('m/d Y'),
            'date_comp'                   => $this->start_time->format('Ymd'),
            'start_time'                  => $this->start_time->format('H:i'),
            'end_time'                    => $this->end_time->format('H:i'),
            'service_period'              => $this->service_period,
            'client_id'                   => $this->client_id,
            'client_code'                 => $this->client->client_code,
            'client_name'                 => $this->client->name,
            'engagement_code_id'          => $this->engagement_code_id,
            'engagement_code'             => $this->engagement_code->code,
            'engagement_code_description' => $this->engagement_code->description,
            'description'                 => $this->description,
            'notes'                       => $this->notes,
            'duration'                    => $this->duration()->asString()
        ];
    }
}
