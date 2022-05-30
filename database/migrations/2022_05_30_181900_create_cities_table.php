<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('latlong');
            $table->timestamps();
        });

        DB::Table('cities')
            ->insert([
                        [
                            'name' => 'New York',
                            'latlong' => '40.730610, -73.935242'
                        ],
                        [
                            'name' => 'London',
                            'latlong' => '51.509865, -0.118092'
                        ],
                        [
                            'name' => 'Berlin',
                            'latlong' => '52.520008, 13.404954'
                        ],
                        [
                            'name' => 'Tokyo',
                            'latlong' => '35.652832, 139.839478'
                        ]
                    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
