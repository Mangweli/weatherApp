<?php

namespace App\Repositories\Interfaces;

interface DailyForecastInterface {
    public function getForecastFromAPI($url);
    public function getDailyForecastByDate($from, $to);
    public function getDailyWeatherByDate($from, $to);
    public function getDailyTempByDate($from, $to);
    public function getDailyFeellikeByDate($from, $to);
    public function setDailyForecast($dailyForecastData);
    public function setTemp($tempData);
    public function setFeelLike($feelLikeData);
    public function setWeather($weatherData);
}
