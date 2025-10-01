<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->float('pm25');     // for PM2.5
            $table->float('pm10');     // for PM10
            $table->float('no2');      // Nitrogen dioxide
            $table->float('co');       // Carbon monoxide
            $table->float('rtc');      // Real-time clock / other metric
            $table->float('decibel');  // Sound level in dB
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
