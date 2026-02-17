<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->datetime('weather_timestamp')->unique();
            $table->float('temperature_2m')->nullable();
            $table->float('relative_humidity_2m')->nullable();
            $table->float('windspeed_10m')->nullable();
            $table->float('winddirection_10m')->nullable();
            $table->float('pressure_msl')->nullable();
            $table->float('precipitation')->nullable();
            $table->integer('weather_code')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
