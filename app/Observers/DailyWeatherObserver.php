<?php

namespace App\Observers;

use App\Models\Weather;
use Illuminate\Support\Facades\Cache;

class DailyWeatherObserver
{
    /**
     * Handle the Weather "created" event.
     *
     * @param  \App\Models\Weather  $weather
     * @return void
     */
    public function created(Weather $weather)
    {
        Cache::forget('dailyWeather');
    }

    /**
     * Handle the Weather "updated" event.
     *
     * @param  \App\Models\Weather  $weather
     * @return void
     */
    public function updated(Weather $weather)
    {
        Cache::forget('dailyWeather');
    }

}
