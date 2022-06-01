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
            $table->string('name')->unique()->index();
            $table->string('lat');
            $table->string('lon');
            $table->string('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        DB::Table('cities')
            ->insert([
                        ['name' => 'New York', 'lat' => '40.730610', 'lon' => '-73.935242', 'created_by' => 'system'],
                        ['name' => 'London', 'lat' => '51.509865', 'lon' => '-0.118092', 'created_by' => 'system'],
                        ['name' => 'Berlin', 'lat' => '52.520008', 'lon' => '13.404954', 'created_by' => 'system'],
                        ['name' => 'Tokyo', 'lat' => '35.652832','lon' => '139.839478', 'created_by' => 'system']
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
