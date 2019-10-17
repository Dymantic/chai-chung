<?php


namespace App\Time;


class WorkDay
{

    const OVERTIME_LOWER = 1.33;
    const OVERTIME_HIGHER = 1.67;

    public $sessions;


    public function __construct($sessions)
    {
        $this->sessions = $sessions;
    }

    public function costOfDay($rate)
    {
        $hours = $this->totalHours();

        if ($hours <= 8) {
            return $this->baseCost($hours, $rate);
        }

        if ($hours <= 10) {
            return $this->baseCost(8, $rate) + $this->lowerOvertime($hours - 8, $rate);
        }

        return $this->baseCost(8, $rate) +
            $this->lowerOvertime(2, $rate) +
            $this->higherOvertime($hours - 10, $rate);
    }

    private function baseCost($hours, $rate)
    {
        return $hours * $rate;
    }

    private function lowerOvertime($hours, $rate)
    {
        return $hours * $rate * static::OVERTIME_LOWER;
    }

    private function higherOvertime($hours, $rate)
    {
        return $hours * $rate * static::OVERTIME_HIGHER;
    }

    public function canAcceptSession($new_period)
    {
        $all_hours = $this->intendedTimePeriods($new_period);

        return (!$this->willBeTooManyConsecutiveHours($all_hours)) && (!$this->periodOverlapsSession($new_period));
    }

    public function canAcceptSessionUpdate($session_id, $new_period)
    {
        $all_hours = $this->intendedTimePeriods($new_period, $session_id);

        return (!$this->willBeTooManyConsecutiveHours($all_hours)) &&
            (!$this->periodOverlapsSession($new_period, $session_id));
    }

    public function totalHours()
    {
        $minutes = $this->sessions->sum(function ($session) {
            return $session->duration()->minutes();
        });

        return $minutes / 60;
    }

    public function totalOvertime()
    {
        $minutes = $this->sessions->sum('overtime_minutes');

        return $minutes / 60;
    }

    private function periodOverlapsSession($new_period, $exclude = null)
    {
        return $this
            ->sessions
            ->reject(function ($session) use ($exclude) {
                return $exclude && $exclude === $session->id;
            })
            ->contains(function ($session) use ($new_period) {
                return $new_period->overlapsWith(new TimePeriod(TimeOfDay::fromDate($session->start_time),
                    TimeOfDay::fromDate($session->end_time)));
            });
    }

    private function willBeTooManyConsecutiveHours($periods)
    {
        $consecutive = 0;
        for ($x = 0; $x < $periods->count(); $x++) {
            if ($x === 0) {
                $consecutive = $periods[0]->duration();
                continue;
            }
            if ($periods[$x]->start->isEqualTo($periods[$x - 1]->end)) {
                $consecutive = $consecutive + $periods[$x]->duration();

                if ($consecutive > (4 * 60)) {
                    return true;
                }
            } else {
                $consecutive = $periods[$x]->duration();
            }
        }

        return false;
    }

    private function intendedTimePeriods($including, $exclude = null)
    {
        return $this
            ->sessions
            ->reject(function ($session) use ($exclude) {
                return $exclude && $exclude === $session->id;
            })
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