<?php


namespace App\Time;


class WorkDay
{

    private $sessions;

    public function __construct($sessions)
    {
        $this->sessions = $sessions;
    }

    public function canAcceptSession($new_period)
    {
        $all_hours = $this->intendedTimePeriods($new_period);

        return (! $this->willBeTooManyConsecutiveHours($all_hours)) && (! $this->periodOverlapsSession($new_period));
    }

    private function periodOverlapsSession($new_period)
    {
        return $this
            ->sessions
            ->contains(function($session) use ($new_period) {
                return $new_period->overlapsWith(new TimePeriod(TimeOfDay::fromDate($session->start_time), TimeOfDay::fromDate($session->end_time)));
            });
    }

    private function willBeTooManyConsecutiveHours($periods)
    {
        $consecutive = 0;
        for($x = 0; $x < $periods->count(); $x++) {
            if($x === 0) {
                $consecutive = $periods[0]->duration();
                continue;
            }
            if($periods[$x]->start->isEqualTo($periods[$x - 1]->end)) {
                $consecutive = $consecutive + $periods[$x]->duration();

                if($consecutive > (4 * 60)) {
                    return true;
                }
            } else {
                $consecutive = $periods[$x]->duration();
            }
        }
        return false;
    }

    private function intendedTimePeriods($including)
    {
        return $this
            ->sessions
            ->map(function ($session) {
                return new TimePeriod(TimeOfDay::fromDate($session->start_time),
                    TimeOfDay::fromDate($session->end_time));
            })
            ->push($including)
            ->sortBy(function ($period) {
                return $period->start->asDate();
            })
            ->values();
    }
}