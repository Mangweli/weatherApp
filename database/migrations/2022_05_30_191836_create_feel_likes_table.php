<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeelLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feel_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('date')->index();
            $table->integer('day')->index();
            $table->integer('night')->index();
            $table->integer('eve')->index();
            $table->integer('morn')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('daily_forecast_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feel_likes');
    }
}
