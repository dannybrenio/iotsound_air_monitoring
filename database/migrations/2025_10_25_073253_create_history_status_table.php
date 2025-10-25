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
        Schema::create('history_status', function (Blueprint $table) {
            $table->id('history_id');

            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('status_id')->on('device_status')->onDelete('cascade');


            $table->string('sensor_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('history_status');  
        Schema::dropIfExists('device_status');
        Schema::enableForeignKeyConstraints();
    }
};
