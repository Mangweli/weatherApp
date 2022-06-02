<?php

namespace App\Jobs;

use App\Repositories\Interfaces\DailyForecastInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CityDailyTempJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $temp;
    private $date;
    private $city_id;
    private $daily_forecast_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($temp, $date, $city_id, $forecast_id)
    {
        $this->temp              = $temp;
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

        if(is_array($this->temp)) {
            foreach($this->temp as $tempValue) {
                $tempValue->date              = $this->date;
                $tempValue->city_id           = $this->city_id;
                $tempValue->daily_forecast_id = $this->daily_forecast_id;

                $dailyForecastRepository->setTemp((array)$tempValue);
            }
        }else {
            $this->temp->date              = $this->date;
            $this->temp->city_id           = $this->city_id;
            $this->temp->daily_forecast_id = $this->daily_forecast_id;

            $dailyForecastRepository->setTemp((array)$this->temp);
        }
    }
}
