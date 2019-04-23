<?php


namespace App\Time;


class SessionSummary
{
    private $sessions;

    public function __construct($sessions)
    {
        $this->sessions = $sessions;
    }

    public function total_time()
    {
        return $this
            ->sessions
            ->map(function($session) {
                return $session->duration()->minutes();
            })
            ->sum();
    }

    public function total_overtime()
    {
        return $this
            ->sessions
            ->map(function($session) {
                return $session->overtime();
            })
            ->sum();
    }
}