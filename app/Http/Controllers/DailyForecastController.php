<?php

namespace App\Http\Controllers;

use App\Event\DailyForecastEvent;
use App\Jobs\CityDailyFeelLikeJob;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DailyForecastController extends Controller
{

    private DailyForecastInterface $dailyForecastRepository;
    private CityInterface $cityRepository;

    public function __construct(DailyForecastInterface $dailyForecastRepository, CityInterface $cityRepository)
    {
        $this->dailyForecastRepository = $dailyForecastRepository;
        $this->cityRepository          = $cityRepository;
    }

    public function getForecast() {
        $payload['dt']      = strtotime(Carbon::today());
        $payload['appid']   = Config::get('settings.WEATHER_FORECAST_APPID');
        $payload['exclude'] = 'minutely';
        $cities             = $this->cityRepository->getSystemCities();

        foreach($cities as $city) {
            $payload['lat'] = $city['lat'];
            $payload['lon'] = $city['lon'];
            $url            = Config::get('settings.WEATHER_FORECAST_API_URL').'?'.http_build_query($payload);
            $forecastData   = $this->dailyForecastRepository->getForecastFromAPI($url);

            if(!empty($forecastData) && property_exists($forecastData, 'daily')) {
                foreach($forecastData->daily as $dailyForecast) {

                    $feelLike               = $dailyForecast->feels_like;
                    $temp                   = $dailyForecast->temp;
                    $weather                = $dailyForecast->weather;
                    $dailyForecast->city_id = $city['id'];

                    unset($dailyForecast->feels_like);
                    unset($dailyForecast->temp);
                    unset($dailyForecast->weather);

                    $dailyForecastDetails = $this->dailyForecastRepository->setDailyForecast((array)$dailyForecast);
                    DailyForecastEvent::dispatch($feelLike, $temp, $weather, $city['id'], $dailyForecastDetails->id, $dailyForecast->dt);
                }
            }
        }
    }
}
