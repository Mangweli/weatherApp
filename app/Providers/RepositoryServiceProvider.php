<?php

namespace App\Providers;

use App\Repositories\CityRepositories;
use App\Repositories\DailyForecastRepositories;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DailyForecastInterface::class, DailyForecastRepositories::class);
        $this->app->bind(CityInterface::class, CityRepositories::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
