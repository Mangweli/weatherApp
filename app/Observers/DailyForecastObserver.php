<?php

namespace App\Observers;

use App\Models\DailyForecast;
use Illuminate\Support\Facades\Cache;

class DailyForecastObserver
{
    /**
     * Handle the DailyForecast "created" event.
     *
     * @param  \App\Models\DailyForecast  $dailyForecast
     * @return void
     */
    public function created(DailyForecast $dailyForecast)
    {
        Cache::forget('dailyForecast');
    }

    /**
     * Handle the DailyForecast "updated" event.
     *
     * @param  \App\Models\DailyForecast  $dailyForecast
     * @return void
     */
    public function updated(DailyForecast $dailyForecast)
    {
        Cache::forget('dailyForecast');
    }

}
