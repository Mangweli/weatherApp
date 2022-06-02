<?php

namespace App\Jobs;

use App\Repositories\Interfaces\DailyForecastInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CityDailyWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $weather;
    private $date;
    private $city_id;
    private $daily_forecast_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($weather, $date, $city_id, $forecast_id)
    {
        $this->weather           = $weather;
        $this->date              = $date;
        $this->city_id           = $city_id;
        $this->daily_forecast_id = $forecast_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DailyForecastInterface $dailyForecastRepository)
    {
        $type = "DAILY";

        if(is_array($this->weather)) {
            foreach($this->weather as $weatherValue) {
                $weatherValue->third_party_id    = $weatherValue->id;
                $weatherValue->date              = $this->date;
                $weatherValue->city_id           = $this->city_id;
                $weatherValue->type              = $type;
                $weatherValue->daily_forecast_id = $this->daily_forecast_id;

                unset($weatherValue->id);

                $dailyForecastRepository->setWeather((array)$weatherValue);
            }
        }else {
            $this->weather->third_party_id    = $this->weather->id;
            $this->weather->date              = $this->date;
            $this->weather->city_id           = $this->city_id;
            $this->weather->type              = $type;
            $this->weather->daily_forecast_id = $this->daily_forecast_id;

            unset($this->weather->id);

            $dailyForecastRepository->setTemp((array)$this->weather);
        }
    }
}
