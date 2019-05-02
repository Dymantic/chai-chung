<?php

namespace App\Providers\App\Listeners;

use App\Providers\App\Events\SessionCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetOvertimeMinutes
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SessionCreated  $event
     * @return void
     */
    public function handle(SessionCreated $event)
    {
        //
    }
}
