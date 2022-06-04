<?php

namespace App\Listeners;

use App\Event\DailyForecastEvent;
use App\Jobs\CityDailyFeelLikeJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DailyFeelLikeListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Event\DailyForecastEvent  $event
     * @return void
     */
    public function handle(DailyForecastEvent $event)
    {
        CityDailyFeelLikeJob::dispatch($event->feelLike, $event->date, $event->cityId, $event->dailyForecastID);
    }
}
