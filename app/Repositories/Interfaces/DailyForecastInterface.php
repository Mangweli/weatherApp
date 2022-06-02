<?php

namespace App\Repositories\Interfaces;

interface DailyForecastInterface {
    public function getForecastFromAPI($url);
    public function setDailyForecast($dailyForecastData);
    public function setTemp($tempData);
    public function setFeelLike($feelLikeData);
    public function setWeather($weatherData);
}
