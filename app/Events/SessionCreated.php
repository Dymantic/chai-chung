<?php


namespace App\Events;


use App\Time\Session;
use Illuminate\Foundation\Events\Dispatchable;

class SessionCreated
{
    use Dispatchable;

    public $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }
}