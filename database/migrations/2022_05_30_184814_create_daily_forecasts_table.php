<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_forecasts', function (Blueprint $table) {
            $table->id();
            $table->integer('date');
            $table->integer('sunrise');
            $table->integer('sunset');
            $table->integer('moonrise');
            $table->integer('moonset');
            $table->integer('moon_phase');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->integer('dew_point');
            $table->integer('wind_speed');
            $table->integer('wind_deg');
            $table->integer('wind_gust');
            $table->integer('clouds');
            $table->integer('pop');
            $table->integer('uvi');
            $table->timestamps();
            $table->foreignId('city_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_forecasts');
    }
}
