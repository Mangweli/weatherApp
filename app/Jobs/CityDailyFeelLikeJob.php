<?php

namespace App\Jobs;

use App\Repositories\Interfaces\DailyForecastInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CityDailyFeelLikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $feelLike;
    private $date;
    private $city_id;
    private $daily_forecast_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feelLike, $date, $city_id, $forecast_id)
    {
        $this->feelLike          = $feelLike;
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
        if(is_array($this->feelLike)) {
            foreach($this->feelLike as $feelLikeValue) {
                $feelLikeValue->date              = $this->date;
                $feelLikeValue->city_id           = $this->city_id;
                $feelLikeValue->daily_forecast_id = $this->daily_forecast_id;

                $dailyForecastRepository->setFeelLike((array)$feelLikeValue);
            }
        }else {
            $this->feelLike->date              = $this->date;
            $this->feelLike->city_id           = $this->city_id;
            $this->feelLike->daily_forecast_id = $this->daily_forecast_id;

            $dailyForecastRepository->setFeelLike((array)$this->feelLike);
        }
    }
}
