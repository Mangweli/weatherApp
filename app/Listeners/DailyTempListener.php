<?php

namespace App\Listeners;

use App\Event\DailyForecastEvent;
use App\Jobs\CityDailyTempJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DailyTempListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Event\DailyForcastEvent  $event
     * @return void
     */
    public function handle(DailyForecastEvent $event)
    {
        CityDailyTempJob::dispatch($event->temp, $event->date, $event->cityId, $event->dailyForecastID);
    }
}
