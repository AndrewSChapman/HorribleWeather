<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CurrentWeather extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_item', function (Blueprint $table) {
            $table->string('id', 40);
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->string('location_id', 40);
            $table->string('type', 255);
            $table->string('description', 255);
            $table->float('temperature');
            $table->float('wind_speed');
            $table->string('icon', 20);
            $table->primary('id');
            $table->index('created_at', 'idx_weather_item_created_at');
            $table->foreign('location_id')->references('id')->on('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('weather_item');
    }
}
