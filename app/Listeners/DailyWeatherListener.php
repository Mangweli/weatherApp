<?php

namespace App\Listeners;

use App\Event\DailyForecastEvent;
use App\Jobs\CityDailyWeatherJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DailyWeatherListener
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
    public function handle(DailyForecastEvent $event)
    {
        CityDailyWeatherJob::dispatch($event->weather, $event->date, $event->cityId, $event->dailyForecastID);
    }
}
