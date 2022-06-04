<?php

namespace Tests\Feature;

use App\Event\DailyForecastEvent;
use App\Listeners\DailyFeelLikeListener;
use App\Listeners\DailyTempListener;
use App\Listeners\DailyWeatherListener;
use App\Models\City;
use App\Models\DailyForecast;
use App\Models\FeelLike;
use App\Models\Temperature;
use App\Models\Weather;
use App\Repositories\DailyForecastRepository;
use App\Repositories\Interfaces\CityInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Traits\UtilityFunctions;
use Tests\TestCase;

class DailyForecastTest extends TestCase
{
    use RefreshDatabase, UtilityFunctions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cityRepository          = $this->app->make(CityInterface::class);
        $this->dailyForecastRepository = $this->app->make(DailyForecastRepository::class);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_daily_forecast_all_end_point_requires_date_parameter()
    {
        $response = $this->get('/api/v1/daily-forecast/all');

        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => false,
                                    'source' => false,
                                    'message' => 'Invalid or missing date'
                            ]);
    }

    public function test_daily_forecast_weather_end_point_requires_date_parameter()
    {
        $response = $this->get('/api/v1/daily-forecast/weather');

        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => false,
                                    'source' => false,
                                    'message' => 'Invalid or missing date'
                            ]);
    }

    public function test_daily_forecast_temp_end_point_requires_date_parameter()
    {
        $response = $this->get('/api/v1/daily-forecast/temp');

        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => false,
                                    'source' => false,
                                    'message' => 'Invalid or missing date'
                            ]);
    }

    public function test_daily_forecast_feel_like_end_point_requires_date_parameter()
    {
        $response = $this->get('/api/v1/daily-forecast/feel-like');

        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => false,
                                    'source' => false,
                                    'message' => 'Invalid or missing date'
                            ]);
    }

    public function test_daily_forecast_all_end_point_returns_success_with_date_parameter()
    {
        $date     = Carbon::now()->toDateString();
        $response = $this->get('/api/v1/daily-forecast/all?date='.$date);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => true,
                                    'source' => 'External'
                            ]);
    }

    public function test_daily_forecast_all_end_point_returns_data_from_external_api_if_record_not_found_in_database()
    {
        $this->assertEquals(0, DailyForecast::count());
        $date     = Carbon::now()->toDateString();
        $response = $this->get('/api/v1/daily-forecast/all?date='.$date);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => true,
                                    'source' => 'External'
                            ]);
    }

    public function test_daily_forecast_all_end_point_returns_data_from_db_if_exits()
    {
        $this->withoutExceptionHandling();
        DailyForecast::factory()->create();
        $this->assertEquals(1, DailyForecast::count());

        $date     = Carbon::now()->toDateString();
        $response = $this->get('/api/v1/daily-forecast/all?date='.$date);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => true,
                                    'source' => 'Internal'
                            ]);
    }

    public function test_daily_forecast_all_end_point_returns_error_message_if_no_data_found()
    {
        $this->assertDatabaseCount('daily_forecasts', 0);

        $response = $this->get('/api/v1/daily-forecast/all?date=1990-06-03');

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => false,
                                    'source' => false,
                                    'message' => 'No data Available'
                            ]);
    }

    public function test_daily_weather_listener_is_listening_on_daily_weather_forecast_event() {
        Event::fake(['DailyForecastEvent']);

        Event::assertListening(
            DailyForecastEvent::class,
            DailyWeatherListener::class
        );
    }

    public function test_daily_weather_listener_is_listening_on_daily_feel_like_listener_event() {
        Event::fake(['DailyForecastEvent']);

        Event::assertListening(
            DailyForecastEvent::class,
            DailyFeelLikeListener::class
        );
    }

    public function test_daily_weather_listener_is_listening_on_daily_temp_listener_event() {
        Event::fake(['DailyForecastEvent']);

        Event::assertListening(
            DailyForecastEvent::class,
            DailyTempListener::class
        );
    }

    public function test_can_saves_daily_forecast_details_to_db_successfully() {
        $from   = strtotime(Carbon::now()->startOfDay());
        $cities = $this->cityRepository->getSystemCities();
        $this->assertEquals(0, DailyForecast::count());

        $dailyForecast = $this->getDailyForecastByDate($cities, $from);
        $this->assertNotEmpty($dailyForecast);
        $this->assertNotEquals(0, DailyForecast::count());
    }

    public function test_can_saves_daily_weather_details_to_db_successfully() {
        $from   = strtotime(Carbon::now()->startOfDay());
        $cities = $this->cityRepository->getSystemCities();
        $this->assertEquals(0, Weather::count());

        $dailyForecast = $this->getDailyForecastByDate($cities, $from);
        $this->assertNotEmpty($dailyForecast);
        $this->assertNotEquals(0, Weather::count());
    }

    public function test_can_saves_daily_temp_details_to_db_successfully() {
        $from   = strtotime(Carbon::now()->startOfDay());
        $cities = $this->cityRepository->getSystemCities();
        $this->assertEquals(0, Temperature::count());

        $dailyForecast = $this->getDailyForecastByDate($cities, $from);
        $this->assertNotEmpty($dailyForecast);
        $this->assertNotEquals(0, Temperature::count());
    }

    public function test_can_saves_daily_feel_like_details_to_db_successfully() {
        $from   = strtotime(Carbon::now()->startOfDay());
        $cities = $this->cityRepository->getSystemCities();
        $this->assertEquals(0, FeelLike::count());

        $dailyForecast = $this->getDailyForecastByDate($cities, $from);
        $this->assertNotEmpty($dailyForecast);
        $this->assertNotEquals(0, FeelLike::count());
    }

    public function test_can_retrieve_data_from_API() {

    }


}
