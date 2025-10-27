<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pending_hardware_data', function (Blueprint $table) {
            $table->id('pending_hardware_data_id');
            $table->string('pending_hardware_info');
            $table->float('pm2_5', 8, 2);
            $table->float('pm10', 8, 2);
            $table->float('co', 8, 2);
            $table->float('no2', 8, 2);
            $table->float('decibels', 8, 2);
            $table->dateTime('realtime_stamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_hardware_data');
    }
};
