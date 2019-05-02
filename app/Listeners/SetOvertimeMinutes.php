<?php


namespace App\Listeners;


use App\Events\SessionCreated;
use App\Time\Session;

class SetOvertimeMinutes
{
    public function handle(SessionCreated $event)
    {
        Session::withoutEvents(function() use ($event) {
            $event->session->setOvertime();
        });
    }
}