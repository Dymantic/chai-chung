<?php

namespace App\Time;

use App\Clients\Client;
use App\Clients\EngagementCode;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $dates = ['start_time', 'end_time'];

    public function duration()
    {
        $mins = $this->end_time->diffInMinutes($this->start_time);
        return new Duration($mins);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function engagement_code()
    {
        return $this->belongsTo(EngagementCode::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'date' => $this->start_time->format('m/d Y'),
            'date_comp' => $this->start_time->format('Ymd'),
            'start_time' => $this->start_time->format('H:i'),
            'end_time' => $this->end_time->format('H:i'),
            'service_period' => $this->service_period,
            'client_id' => $this->client_id,
            'client_code' => $this->client->client_code,
            'client_name' => $this->client->name,
            'engagement_code_id' => $this->engagement_code_id,
            'engagement_code' => $this->engagement_code->code,
            'engagement_code_description' => $this->engagement_code->description,
            'description' => $this->description,
            'notes' => $this->notes,
            'duration' => $this->duration()->asString()
        ];
    }
}
