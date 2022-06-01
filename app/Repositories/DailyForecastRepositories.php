<?php

namespace App\Repositories;

use App\Models\DailyForecast;
use App\Models\FeelLike;
use App\Repositories\Interfaces\DailyForecastInterface;
use GuzzleHttp\Client;

class DailyForecastRepositories implements DailyForecastInterface
{
    public function getForecastFromAPI($url) {
        $client = new Client();

        if(strlen($url) < 10) {
            return (object)[];
        }

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        return json_decode($response->getBody());
    }

    public function setDailyForecast($dailyForecastData) {
        $forecastchecker = DailyForecast::where('dt', $dailyForecastData['dt'])
                                        ->where('city_id', $dailyForecastData['city_id'])
                                        ->first('id');

        if(empty($forecastchecker)) {
            return DailyForecast::create($dailyForecastData);
        }

        DailyForecast::where('dt', $dailyForecastData['dt'])
                    ->where('id', $forecastchecker->id)
                    ->where('city_id', $dailyForecastData['city_id'])
                    ->update($dailyForecastData);

        return $forecastchecker;

    }

    public function setDailyTemp() {

    }

    public function setFeelLike($feelLikeData) {
        return FeelLike::upsert([$feelLikeData, ['date', 'city_id', 'daily_forecast_id']]);
    }

    public function setWeather($data, $type) {

    }
}
