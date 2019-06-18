<?php


namespace App\Time;


use Illuminate\Support\Carbon;

class Duration
{

    private $minutes;

    public function __construct($minutes)
    {
        $this->minutes = $minutes;
    }

    public static function fromTimes($start, $end)
    {
        $start = new TimeOfDay($start);
        $end = new TimeOfDay($end);

        if((!$start->isValid()) || (!$end->isValid())) {
            throw new \Exception("invalid time of days");
        }

        $begin = Carbon::now()->setHour($start->hours)->setMinutes($start->mins);
        $end = Carbon::now()->setHour($end->hours)->setMinutes($end->mins);

        $mins = $end->diffInMinutes($begin);
        return new static($mins);
    }

    public function minutes() {
        return $this->minutes;
    }

    public function asString()
    {
        $hours = floor($this->minutes / 60);
        $mins = $this->minutes % 60;
        $padded_mins = $this->pad($mins);

        if ($hours > 0 && $mins > 0) {
            return "{$hours} 小時 {$padded_mins} 分鐘";
        }

        if ($hours > 0 && $mins === 0) {
            return "{$hours} 小時";
        }

        return "{$padded_mins} 分鐘";

    }

    private function pad($value)
    {
        return $value < 10 ? "0" . $value : $value;
    }
}