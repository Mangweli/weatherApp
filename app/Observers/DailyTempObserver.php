<?php

namespace App\Observers;

use App\Models\Temperature;
use Illuminate\Support\Facades\Cache;

class DailyTempObserver
{
    /**
     * Handle the Temperature "created" event.
     *
     * @param  \App\Models\Temperature  $temperature
     * @return void
     */
    public function created(Temperature $temperature)
    {
        Cache::forget('dailyTemp');
    }

    /**
     * Handle the Temperature "updated" event.
     *
     * @param  \App\Models\Temperature  $temperature
     * @return void
     */
    public function updated(Temperature $temperature)
    {
        Cache::forget('dailyTemp');
    }
}
