<?php

namespace App\Rules;

use App\Time\TimeOfDay;
use App\Time\TimePeriod;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class WorkPeriod implements Rule
{
    private $user;
    private $end;
    private $date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user, $end, $date)
    {
        $this->user = $user;
        $this->end = $end;
        $this->date = $date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            Carbon::parse($this->date);
        } catch (\Exception $e) {
            return false;
        }

        $workDay = $this->user->workDay($this->date);
        $session = new TimePeriod(new TimeOfDay($value), new TimeOfDay($this->end));

        return $workDay->canAcceptSession($session);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
