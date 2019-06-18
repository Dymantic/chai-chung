<?php


namespace App\Time;


class TimeOfDay
{
    private $timeString;
    public $hours;
    public $mins;

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
}