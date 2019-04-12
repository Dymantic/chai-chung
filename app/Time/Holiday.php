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
