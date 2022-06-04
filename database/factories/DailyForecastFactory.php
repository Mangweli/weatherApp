<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyForecastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "dt"         => strtotime(Carbon::now()),
            "sunrise"    => "3",
            "sunset"     => "3",
            "moonrise"   => "3",
            "moonset"    => "3",
            "moon_phase" => "3",
            "pressure"   => "3",
            "humidity"   => "3",
            "dew_point"  => "3",
            "wind_speed" => "3",
            "wind_deg"   => "3",
            "wind_gust"  => "3",
            "clouds"     => "3",
            "pop"        => "3",
            "rain"       => "3",
            "uvi"        => "3",
            "city_id"    => "3"
        ];
    }
}
