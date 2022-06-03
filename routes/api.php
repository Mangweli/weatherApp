<?php

use App\Http\Controllers\DailyForecastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/daily-forecast/')->group(function() {
    Route::get('all', [DailyForecastController::class, 'getDailyForecast']);
    Route::get('weather', [DailyForecastController::class, 'getDailyWeather']);
    Route::get('temp', [DailyForecastController::class, 'getDailyTemp']);
    Route::get('feel-like', [DailyForecastController::class, 'getDailyFeelLike']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
