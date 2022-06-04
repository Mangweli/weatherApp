<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Event\DailyForecastEvent;
use App\Listeners\DailyFeelLikeListener;
use App\Listeners\DailyWeatherListener;
use App\Listeners\DailyTempListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        DailyForecastEvent::class => [
            DailyFeelLikeListener::class,
            DailyWeatherListener::class,
            DailyTempListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
