<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StartEndTime implements Rule
{

    private $cutoff;

    public function __construct($cutoff = null)
    {
        $this->cutoff = $cutoff;
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
        $parts = explode(":", $value);

        if(count($parts) !== 2) {
            return false;
        }

        $hour = $parts[0];
        $mins = $parts[1];

        if($this->hourIsInvalid($hour)) {
            return false;
        }

        if($this->minutesAreInvalid($mins)) {
            return false;
        }

        if($this->isBeforeCutoff(intval($hour), intval($mins))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '開始與結束的時間必須是有效的時間，例如08:30';
    }

    private function hourIsInvalid($hour)
    {
        $matches = preg_match("/[012]?[0-9]/", $hour);

        if($matches === 0) {
            return true;
        };

        if(intval($hour) < 0 || intval($hour) > 23) {
            return true;
        }

    }

    private function minutesAreInvalid($minutes)
    {
        $matches = preg_match("/[0-5][0-9]/", $minutes);

        if($matches === 0) {
            return true;
        };

        $minutes = intval($minutes);

        if($minutes < 0 || $minutes > 59) {
            return true;
        }

        if(($minutes !== 0) && ($minutes !== 30)) {
            return true;
        }
    }

    private function isBeforeCutoff($hours, $mins)
    {
        if(!$this->hasValidCuttoff()) {
            return false;
        }

        $parts = explode(":", $this->cutoff);
        $cutoff_hour = intval($parts[0]);
        $cutoff_mins = intval($parts[1]);

        if($hours < $cutoff_hour) {
            return true;
        }

        if($hours === $cutoff_hour && ($cutoff_mins >= $mins)) {
            return true;
        }
    }

    private function hasValidCuttoff()
    {
        $matches = preg_match("/[012]?[0-9]:[0-5][0-9]/", $this->cutoff);

        return $matches === 1;
    }
}
