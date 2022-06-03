<?php


namespace App\Traits;

use App\Event\DailyForecastEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

trait UtilityFunctions {
    public function getDailyForecastByDate($cities, $date) {
        $results            = [];
        $payload['dt']      = $date;
        $payload['appid']   = Config::get('settings.WEATHER_FORECAST_APPID');
        $payload['exclude'] = 'minutely';

        foreach($cities as $city) {
            $payload['lat'] = $city['lat'];
            $payload['lon'] = $city['lon'];
            $url            = Config::get('settings.WEATHER_FORECAST_API_URL').'?'.http_build_query($payload);
            $forecastData   = $this->dailyForecastRepository->getForecastFromAPI($url);

            if(!empty($forecastData) && property_exists($forecastData, 'daily')) {
                foreach($forecastData->daily as $dailyForecastKey => $dailyForecast) {


                    $feelLike               = $dailyForecast->feels_like;
                    $temp                   = $dailyForecast->temp;
                    $weather                = $dailyForecast->weather;
                    $dailyForecast->city_id = $city['id'];

                    unset($dailyForecast->feels_like);
                    unset($dailyForecast->temp);
                    unset($dailyForecast->weather);

                    $dailyForecastDetails = $this->dailyForecastRepository->setDailyForecast((array)$dailyForecast);
                    DailyForecastEvent::dispatch($feelLike, $temp, $weather, $city['id'], $dailyForecastDetails->id, $dailyForecast->dt);

                    $results[$dailyForecastKey]                 = $dailyForecast;
                    $results[$dailyForecastKey]->city           = $city;
                    $results[$dailyForecastKey]->daily_weather  = $city;
                    $results[$dailyForecastKey]->daily_temp     = $weather;
                    $results[$dailyForecastKey]->daily_feellike = $feelLike;
                }
            }

            return $results;
        }
    }
}
