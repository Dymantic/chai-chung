<?php


namespace App\Time;


use Illuminate\Support\Carbon;

class TimeOfDay
{
    private $timeString;
    public $hours;
    public $mins;

    public static function fromDate($date)
    {
        return new static($date->format("H:i"));
    }

    public function __construct($timeString)
    {
        $this->timeString = $timeString;

        if($this->isValid()) {
            [$hrs, $mns] = explode(":", $timeString);
            $this->hours = intval($hrs);
            $this->mins = intval($mns);
        }


    }

    public function isValid()
    {
        $matches = preg_match("/[0-9]{1,2}:[0-9]{2}/", $this->timeString);

        return $matches === 1 && (strlen($this->timeString) >= 4) && (strlen($this->timeString) <= 5);
    }

    public function asDate()
    {
        return Carbon::today()->setHours($this->hours)->setMinutes($this->mins);
    }

    public function isEqualTo($time)
    {
        return $this->asDate()->equalTo($time->asDate());
    }

    public function isBefore($time)
    {
        return $this->asDate()->isBefore($time->asDate());
    }
}