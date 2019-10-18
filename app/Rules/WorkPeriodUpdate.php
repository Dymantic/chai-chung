<?php

namespace App\Rules;

use App\Time\TimeOfDay;
use App\Time\TimePeriod;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class WorkPeriodUpdate implements Rule
{
    private $user;
    private $end;
    private $date;
    private $session_id;

    public function __construct($user, $end, $date, $session_id)
    {
        $this->user = $user;
        $this->end = $end;
        $this->date = $date;
        $this->session_id = $session_id;
    }


    public function passes($attribute, $value)
    {
        try {
            Carbon::parse($this->date);
        } catch (\Exception $e) {
            return false;
        }

        $workDay = $this->user->workDay($this->date);
        $session = new TimePeriod(new TimeOfDay($value), new TimeOfDay($this->end));

        return $workDay->canAcceptSessionUpdate($this->session_id, $session);
    }

    public function message()
    {
        return '無法更新紀錄因為時間超過４小時或者時間重疊了';
    }
}
