<?php

namespace App\Repositories\Interfaces;

interface DailyForecastInterface {
    public function getForecastFromAPI($url);
    public function setDailyForecast($dailyForecastData);
    public function setFeelLike($feelLikeData);
}
