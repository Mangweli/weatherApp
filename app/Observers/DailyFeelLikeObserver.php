<?php

namespace App\Observers;

use App\Models\FeelLike;
use Illuminate\Support\Facades\Cache;

class DailyFeelLikeObserver
{
    /**
     * Handle the FeelLike "created" event.
     *
     * @param  \App\Models\FeelLike  $feelLike
     * @return void
     */
    public function created(FeelLike $feelLike)
    {
        Cache::forget('dailyFeelLike');
    }

    /**
     * Handle the FeelLike "updated" event.
     *
     * @param  \App\Models\FeelLike  $feelLike
     * @return void
     */
    public function updated(FeelLike $feelLike)
    {
        Cache::forget('dailyFeelLike');
    }
}
