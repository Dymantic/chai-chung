<?php


namespace App\Time;


class TimePeriod
{
    public $start;
    public $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function duration()
    {
        return $this->end->asDate()->diffInMinutes($this->start->asDate());
    }

    public function overlapsWith($period)
    {
        if($period->end->isBeforeOrEqual($this->start)) {
            return false;
        }

        if($this->end->isBeforeOrEqual($period->start)) {
            return false;
        }

        return true;
    }
}