<?php

namespace App\Rules;

use App\Time\Duration;
use Illuminate\Contracts\Validation\Rule;

class MaximumHours implements Rule
{
    public $max_hours;
    public $start_time;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max_hours, $start_time)
    {
        $this->max_hours = $max_hours;
        $this->start_time = $start_time;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $duration = Duration::fromTimes($this->start_time, $value);
        } catch (\Exception $e) {
            return false;
        }

        return $duration->minutes() <= ($this->max_hours * 60);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "工作時間不能超過{$this->max_hours}小時";
    }
}
