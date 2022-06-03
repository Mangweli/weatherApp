<?php

namespace App\Providers;

use App\Models\DailyForecast;
use App\Models\Temperature;
use App\Models\Weather;
use App\Observers\DailyForecastObserver;
use App\Observers\DailyTempObserver;
use App\Observers\DailyWeatherObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DailyForecast::observe(DailyForecastObserver::class);
        Weather::observe(DailyWeatherObserver::class);
        Temperature::observe(DailyTempObserver::class);
    }
}
