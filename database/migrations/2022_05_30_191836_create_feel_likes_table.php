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
            $table->integer('day');
            $table->integer('night');
            $table->integer('eve');
            $table->integer('morn');
            $table->timestamps();
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
