<?php

namespace Tests\Feature;

use App\Event\DailyForecastEvent;
use App\Models\City;
use App\Models\DailyForecast;
use App\Models\FeelLike;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class DailyForecastTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
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
        $response = $this->get('/api/v1/daily-forecast/all?date=2022-06-03');
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

        $response = $this->get('/api/v1/daily-forecast/all?date=2022-06-03');
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
        DailyForecast::factory()->create(1);
        $this->assertEquals(1, DailyForecast::count());

        $response = $this->get('/api/v1/daily-forecast/all?date=2022-06-03');
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'source', 'message']);
        $response->assertJson(
                                [
                                    'success' => true,
                                    'source' => 'External'
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

    // public function test_daily_weather_listener_is_listening_on_daily_forecast_event() {
    //     $this->withoutExceptionHandling();
    //     Event::fake();

    //     Event::assertListening(
    //         DailyForecastEvent::class,
    //         DailyWeatherListener::class
    //     );
    // }


}
