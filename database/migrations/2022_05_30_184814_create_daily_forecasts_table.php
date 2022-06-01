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
            $table->integer('dt')->index();
            $table->integer('sunrise')->index();
            $table->integer('sunset')->index();
            $table->integer('moonrise')->index();
            $table->integer('moonset')->index();
            $table->integer('moon_phase')->index();
            $table->integer('pressure')->index();
            $table->integer('humidity')->index();
            $table->integer('dew_point')->index();
            $table->integer('wind_speed')->index();
            $table->integer('wind_deg')->index();
            $table->integer('wind_gust')->index();
            $table->integer('clouds')->index();
            $table->integer('pop')->index();
            $table->integer('rain')->index();
            $table->integer('uvi')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
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
