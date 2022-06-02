<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\DailyForecast;
use App\Models\FeelLike;
use App\Models\Temperature;
use App\Models\Weather;
use App\Repositories\Interfaces\DailyForecastInterface;
use GuzzleHttp\Client;

class DailyForecastRepository implements DailyForecastInterface
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

    public function getDailyForecastByDate($from, $to) {
        $dailyWeather = DailyForecast::with([
                                            'city' => function($query) {
                                                $query->select('id','name', 'lat', 'lon');
                                            },
                                            'dailyWeather' => function($query) {
                                                $query->select('main', 'description', 'icon', 'daily_forecast_id');
                                            },
                                            'dailyTemp' => function($query) {
                                                $query->select('id', 'day', 'min', 'max', 'night', 'eve', 'morn', 'daily_forecast_id');
                                            },
                                            'dailyFeellike' => function($query) {
                                                $query->select('day', 'night', 'eve', 'morn', 'daily_forecast_id');
                                            }
                                        ])
                                        ->whereBetween('dt', [$from, $to])
                                        ->select('id', 'dt as date', 'sunrise', 'sunset', 'moonrise', 'moonset', 'moon_phase', 'pressure', 'humidity', 'dew_point', 'wind_speed', 'wind_deg', 'wind_gust', 'clouds', 'pop', 'rain', 'uvi', 'city_id')
                                        ->get()
                                        ->toArray();
        return  $dailyWeather;
    }

    public function getDailyForecastByCity($from, $to) {
         City::with([
                'dailyForecast'  => function($query) {
                    $query->select('id', 'dt as date', 'sunrise', 'sunset', 'moonrise', 'moonset', 'moon_phase', 'pressure', 'humidity', 'dew_point', 'wind_speed', 'wind_deg', 'wind_gust', 'clouds', 'pop', 'rain', 'uvi', 'city_id');
                },
                'dailyFeellike' => function($query) {
                        $query->select('day', 'night', 'eve', 'morn', 'daily_forecast_id');
                },
                'dailyWeather' => function($query) {
                    $query->select('main', 'description', 'icon', 'daily_forecast_id');
                },
                'dailyTemp' => function($query) {
                        $query->select('id', 'day', 'min', 'max', 'night', 'eve', 'morn', 'daily_forecast_id');
                },
                ])
                ->get()
                ->toArray();
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

    public function setTemp($tempData) {
        $tempChecker = Temperature::where('date', $tempData['date'])
                                    ->where('city_id', $tempData['city_id'])
                                    ->where('daily_forecast_id', $tempData['daily_forecast_id'])
                                    ->count();

        if($tempChecker < 1) {
            return Temperature::create($tempData);
        }

        return Temperature::where('date', $tempData['date'])
                            ->where('city_id', $tempData['city_id'])
                            ->where('daily_forecast_id', $tempData['daily_forecast_id'])
                            ->update($tempData);
    }

    public function setFeelLike($feelLikeData) {
        $feelLikeChecker = FeelLike::where('date', $feelLikeData['date'])
                                    ->where('city_id', $feelLikeData['city_id'])
                                    ->where('daily_forecast_id', $feelLikeData['daily_forecast_id'])
                                    ->count();

        if($feelLikeChecker < 1) {
            return FeelLike::create($feelLikeData);
        }

        return FeelLike::where('date', $feelLikeData['date'])
                        ->where('city_id', $feelLikeData['city_id'])
                        ->where('daily_forecast_id', $feelLikeData['daily_forecast_id'])
                        ->update($feelLikeData);
    }

    public function setWeather($weatherData) {
        $weatherChecker = Weather::where('date', $weatherData['date'])
                                    ->where('type', $weatherData['type'])
                                    ->where('city_id', $weatherData['city_id'])
                                    ->where('daily_forecast_id', $weatherData['daily_forecast_id'])
                                    ->count();

        if($weatherChecker < 1) {
            return Weather::create($weatherData);
        }

        return Weather::where('date', $weatherData['date'])
                        ->where('type', $weatherData['type'])
                        ->where('city_id', $weatherData['city_id'])
                        ->where('daily_forecast_id', $weatherData['daily_forecast_id'])
                        ->update($weatherData);

        return Weather::create($weatherData);
    }
}
