<?php

namespace App\Time;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Holiday extends Model
{
    protected $fillable = ['year', 'month', 'day', 'name'];

    public static function setDates($holiday)
    {
        $range = CarbonPeriod::create($holiday['start'], $holiday['end']);

        foreach ($range as $day) {
            static::create([
                'year' => $day->year,
                'month' => $day->month,
                'day' => $day->day,
                'name' => $holiday['name']
            ]);
        }
    }

    public static function existsFor($date)
    {
        $holiday = static::where([
            ['year', '=', $date->year],
            ['month', '=', $date->month],
            ['day', '=', $date->day]
        ])->first();

        return !! $holiday;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'name' => $this->name,
        ];
    }
}
