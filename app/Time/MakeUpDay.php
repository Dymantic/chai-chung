<?php

namespace App\Time;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MakeUpDay extends Model
{
    protected $fillable = ['year', 'month', 'day', 'reason'];

    public static function forDate($date, $reason = 'a make up day')
    {
        $date = Carbon::parse($date);

        return static::create([
            'year'   => $date->year,
            'month'  => $date->month,
            'day'    => $date->day,
            'reason' => $reason
        ]);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'name' => $this->reason,
            'reason' => $this->reason
        ];
    }
}
