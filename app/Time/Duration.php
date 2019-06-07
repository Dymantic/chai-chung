<?php


namespace App\Time;


class Duration
{

    private $minutes;

    public function __construct($minutes)
    {
        $this->minutes = $minutes;
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