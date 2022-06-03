<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\UtilityFunctions;
use Illuminate\Support\Facades\Validator;

class DailyForecastController extends Controller
{
    use UtilityFunctions;

    private DailyForecastInterface $dailyForecastRepository;
    private CityInterface $cityRepository;

    public function __construct(DailyForecastInterface $dailyForecastRepository, CityInterface $cityRepository)
    {
        $this->dailyForecastRepository = $dailyForecastRepository;
        $this->cityRepository          = $cityRepository;
    }

    public function getDailyForecast(Request $request) {
        $results['success'] = false;
        $results['source']  = false;
        $results['message'] = 'No data Available';
        $input              = $request->all();
        $validator          = Validator::make($input, ['date' => 'required|date']);

        if($validator->fails()){
            $results['message'] = 'Invalid or missing date';
            return response()->json($results, 404);
        }

        $from = strtotime(Carbon::parse($request->get('date'))->startOfDay());
        $to   = strtotime(Carbon::parse($request->get('date'))->endOfDay());

       // try {
            $dailyForecast  = $this->dailyForecastRepository->getDailyForecastByDate($from, $to);

            if(!empty($dailyForecast)) {
                $results['success'] = true;
                $results['source']  = 'Internal';
                $results['message'] = $dailyForecast;

                return response()->json($results, 200);
            }

            $cities       = $this->cityRepository->getSystemCities();
            $dailyForecast = $this->getDailyForecastByDate($cities, $from);

            if(!empty($dailyForecast)) {
                $dailyForecast = collect($dailyForecast)->whereBetween('dt', [$from, $to])->all();

                if(!empty($dailyForecast)) {
                    $results['success'] = true;
                    $results['source']  = 'External';
                    $results['message'] = $dailyForecast;
                }

                return response()->json($results, 200);
            }

            return response()->json($results, 404);
        // } catch (\Throwable $th) {
        //     Log::error($th);

        //     $results['message'] = 'Unable to process your request';

        //     return response()->json($results);
        // }

    }

    public function getDailyWeather(Request $request) {
        $results['success'] = false;
        $results['source']  = false;
        $results['message'] = 'No data Available';
        $input              = $request->all();
        $validator          = Validator::make($input, ['date' => 'required|date']);

        if($validator->fails()){
            $results['message'] = 'Invalid or missing date';
            return response()->json($results, 404);
        }
        $from = strtotime(Carbon::parse($request->get('date'))->startOfDay());
        $to   = strtotime(Carbon::parse($request->get('date'))->endOfDay());

        try {
            $dailyWeather  = $this->dailyForecastRepository->getDailyWeatherByDate($from, $to);

            if(!empty($dailyWeather)) {
                $results['success'] = true;
                $results['source']  = 'Internal';
                $results['message'] = $dailyWeather;

                return response()->json($results, 200);
            }
        } catch (\Throwable $th) {
            Log::error($th);

            $results['message'] = 'Unable to process your request';

            return response()->json($results);
        }

    }

    public function getDailyTemp(Request $request) {
        $results['success'] = false;
        $results['source']  = false;
        $results['message'] = 'No data Available';
        $input              = $request->all();
        $validator          = Validator::make($input, ['date' => 'required|date']);

        if($validator->fails()){
            $results['message'] = 'Invalid or missing date';
            return response()->json($results, 404);
        }

        $from = strtotime(Carbon::parse($request->get('date'))->startOfDay());
        $to   = strtotime(Carbon::parse($request->get('date'))->endOfDay());

        try {
            $dailyTemp  = $this->dailyForecastRepository->getDailyTempByDate($from, $to);

            if(!empty($dailyTemp)) {
                $results['success'] = true;
                $results['source']  = 'Internal';
                $results['message'] = $dailyTemp;

                return response()->json($results, 200);
            }
        } catch (\Throwable $th) {
            Log::error($th);

            $results['message'] = 'Unable to process your request';

            return response()->json($results);
        }
    }

    public function getDailyFeelLike(Request $request) {
        $results['success'] = false;
        $results['source']  = false;
        $results['message'] = 'No data Available';
        $input              = $request->all();
        $validator          = Validator::make($input, ['date' => 'required|date']);

        if($validator->fails()){
            $results['message'] = 'Invalid or missing date';
            return response()->json($results, 404);
        }

        $from = strtotime(Carbon::parse($request->get('date'))->startOfDay());
        $to   = strtotime(Carbon::parse($request->get('date'))->endOfDay());

        try {
            $dailyFeellike  = $this->dailyForecastRepository->getDailyFeellikeByDate($from, $to);

            if(!empty($dailyFeellike)) {
                $results['success'] = true;
                $results['source']  = 'Internal';
                $results['message'] = $dailyFeellike;

                return response()->json($results, 200);
            }
        }catch (\Throwable $th) {
            Log::error($th);

            $results['message'] = 'Unable to process your request';

            return response()->json($results);
        }
    }

}
