<?php


namespace App\Time;


use Illuminate\Support\Carbon;

class DateRange
{

    public $from;
    public $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public static function lastNumberOfDays($days, $to_days_ago = 0)
    {
        return new static(Carbon::today()->subDays($days), Carbon::today()->subDays($to_days_ago));
    }

    public function from()
    {
        return $this->from->startOfDay();
    }

    public function to()
    {
        return $this->to->endOfDay();
    }
}