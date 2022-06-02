<?php

namespace App\Http\Controllers;

use App\Event\DailyForecastEvent;
use App\Jobs\CityDailyFeelLikeJob;
use App\Models\City;
use App\Models\DailyForecast;
use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

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
        $from = strtotime(Carbon::now()->startOfDay());
        $to   = strtotime(Carbon::now()->endOfDay());

        $results['success'] = false;
        $results['message'] = 'No data Available';

        try {
            $dailyWeather  = $this->dailyForecastRepository->getDailyForecastByDate($from, $to);

            if(!empty($dailyWeather)) {
                $results['success'] = true;
                $results['message'] = $dailyWeather;

                return response()->json($results, 200);
            }

            if(!empty($dailyWeather)) {
                $dailyWeather       = []; // get from api;
                $results['success'] = true;
                $results['message'] = $dailyWeather;

                return response()->json($results, 200);
            }

            return response()->json($results, 404);

        } catch (\Throwable $th) {

            Log::error($th);

            $results['message'] = 'Unable to process your request';

            return response()->json($results);
        }



    }

    public function getDailyWeather() {

    }

    public function getDailyTemp() {

    }

    public function getDailyFeelLike() {

    }

}
