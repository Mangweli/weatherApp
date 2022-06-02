<?php

namespace App\Console\Commands;

use App\Event\DailyForecastEvent;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class DailyForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves, updates and process daily weather forecast 4 times a day';

    private DailyForecastInterface $dailyForecastRepository;
    private CityInterface $cityRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DailyForecastInterface $dailyForecastRepository, CityInterface $cityRepository)
    {
        $this->dailyForecastRepository = $dailyForecastRepository;
        $this->cityRepository          = $cityRepository;

        parent::__construct();
    }

    public function handle()
    {
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
