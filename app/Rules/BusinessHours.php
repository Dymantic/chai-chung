<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BusinessHours implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return $this->stringIsValid($value) && $this->hoursAreValid($value) && $this->minsAreValid($value);
    }

    private function stringIsValid($timeString)
    {
        $matches = preg_match("/[0-9]{2}:[0-9]{2}/", $timeString);

        return $matches === 1 && (strlen($timeString) === 5);
    }

    private function hoursAreValid($timeString)
    {
        $hours = intval(substr($timeString, 0, 2));

        return $hours > 7 && $hours < 18;
    }

    private function minsAreValid($timeString)
    {
        $mins = intval(substr($timeString, 3, 2));

        return $mins < 7 && $mins < 18;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a valid time.';
    }
}
