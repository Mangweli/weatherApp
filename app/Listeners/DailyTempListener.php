<?php

namespace App\Listeners;

use App\Event\DailyForcastEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DailyTempListener
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
     * @param  \App\Event\DailyForcastEvent  $event
     * @return void
     */
    public function handle(DailyForcastEvent $event)
    {
        //
    }
}
