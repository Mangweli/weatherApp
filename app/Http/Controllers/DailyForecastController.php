<?php

namespace App\Http\Controllers;

use App\Event\DailyForcastEvent;
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
                 //dispatch daily job
                foreach($forecastData->daily as $dailyForecast) {

                    $feelLike               = $dailyForecast->feels_like;
                    $temp                   = $dailyForecast->temp;
                    $weather                = $dailyForecast->weather;
                    $dailyForecast->city_id = $city['id'];

                    unset($dailyForecast->feels_like);
                    unset($dailyForecast->temp);
                    unset($dailyForecast->weather);

                   // dd($dailyForecast,(array)$dailyForecast);

                    $dailyForecastDetails = $this->dailyForecastRepository->setDailyForecast((array)$dailyForecast);

                    DailyForcastEvent::dispatch($dailyForecast, $city['id'], $dailyForecastDetails->id);



                    // CityDailyFeelLikeJob::dispatch($feelLike, $dailyForecast->dt, $city['id']);

                    if(is_array($feelLike)) {
                        foreach($feelLike as $feelLikeValue) {
                            $feelLikeValue->date = $dailyForecast->dt;
                            $feelLikeValue->city_id = $city['id'];
                        }
                    }else {
                        $feelLike->date = $dailyForecast->dt;
                        $feelLike->city_id = $city['id'];
                       dd($this->dailyForecastRepository->setFeelLike((array)$feelLike));
                    }

                    if(is_array($temp)) {
                        foreach($temp as $tempValue) {
                            $tempValue->date = $dailyForecast->dt;
                            $tempValue->city_id = $city['id'];
                        }
                    }else {
                        $temp->date = $dailyForecast->dt;
                        $temp->city_id = $city['id'];
                    }

                    if(is_array($weather)) {
                        foreach($weather as $weatherValue) {
                            $weatherValue->third_party_id = $weatherValue->id;
                            $weatherValue->date           = $dailyForecast->dt;
                            $weatherValue->city_id        = $city['id'];

                            unset($weatherValue->id);
                        }
                    }else {
                        $weather->third_party_id = $weather->id;
                        $weather->date           = $dailyForecast->dt;
                        $weather->city_id        = $city['id'];

                        unset($weather->id);
                    }

                    dd($feelLike, $weather, $temp, $dailyForecast, $payload, $forecastData->daily);
                }

            }

            if(!empty($forecastData) && property_exists($forecastData, 'hourly')) {
                //dispatch hourly job
                dump('hourly');
            }


        }

        dd($cities);





        // $date = appid

       // dd($url);
       DD($this->dailyForecastRepository->getForecastFromAPI($url));
    }
}
