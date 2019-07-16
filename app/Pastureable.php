<?php


namespace App;


use Illuminate\Support\Carbon;

trait Pastureable
{

    public function scopeActive($query)
    {
        return $query->whereNull('pastured_on');
    }

    public function safeDelete()
    {
        $this->pastured_on = Carbon::today();
        $this->save();
    }

    public function isPastured()
    {
        return !! $this->pastured_on;
    }
}