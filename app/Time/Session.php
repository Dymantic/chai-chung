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

    public static function matching($query)
    {
        $from = Carbon::parse($query['from']);
        $to = Carbon::parse($query['to'])->endOfDay();
        $client_id = $query['client_id'] ?? null;
        $user_id = $query['user_id'] ?? null;

        $builder = static::with(['user', 'client', 'engagement_code'])->whereBetween('start_time', [$from, $to]);
        if ($client_id) {
            $builder->where('client_id', $client_id);
        }

        if ($user_id) {
            $builder->where('user_id', $user_id);
        }

        return $builder->get();
    }

    public static function summary($constraints)
    {
        $sessions = static::matching($constraints);

        return new SessionSummary($sessions);
    }

    public static function staffTimeReport($date_range)
    {
        return static::timeReport($date_range, 'user_id', function($session) {
            return $session->user->name;
        });
    }

    public static function clientTimeReport($date_range)
    {
        return static::timeReport($date_range, 'client_id', function($session) {
            return $session->client->name;
        });
    }

    public static function engagementTimeReport($date_range)
    {
        return static::timeReport($date_range, 'engagement_code_id', function($session) {
            return $session->engagement_code->description;
        });
    }

    private static function timeReport($date_range, $group, $get_name)
    {
        $sessions = static::matching($date_range);

        return [
            'date_range' => $date_range['from']->format('Y-m-d') . ' - ' . $date_range['to']->format('Y-m-d'),
            'rows' => $sessions->groupBy($group)
                               ->map(function ($sessions, $id) use ($get_name) {
                                   $summary = new SessionSummary($sessions);

                                   return [
                                       'id'       => $id,
                                       'name'     => $get_name($sessions->first()),
                                       'time'     => $summary->total_time(),
                                       'overtime' => $summary->total_overtime()
                                   ];
                               })->values()->all()
        ];
    }

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

        if (!is_null($this->overtime_set_by)) {
            return $this->overtime_minutes;
        }

        if ($this->on_holiday) {
            return $this->duration()->minutes();
        }

        if ($this->onWeekend() && !$this->on_make_up_day) {
            return $this->duration()->minutes();
        }

        if ($this->duringHours($day_start, $day_end)) {
            return 0;
        }

        if ($this->startedBeforeTime($day_start)) {
            return $this->start_time->diffInMinutes($day_start);
        }

        if ($this->endedAfterDayEnd($day_end)) {
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
        if (!$user->is_manager) {
            return $this->toArray();
        }

        return [
            'id'                          => $this->id,
            'user'                        => $this->user->name,
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
            'cost'                        => $this->user->hourly_rate * ($this->duration()->minutes() / 60),
            'for_manager'                 => true
        ];
    }

    public function toArray()
    {
        return [
            'id'                          => $this->id,
            'user'                        => $this->user->name,
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
        ];
    }
}
