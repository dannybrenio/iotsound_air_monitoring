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
        Schema::create('hardware_data', function (Blueprint $table) {
            $table->id("data_id");
            //foreign key
            $table->unsignedBigInteger('hardware_id');  
            $table->foreign('hardware_id')->references('hardware_id')->on('hardware')->onDelete('cascade');
            $table->float('PM2_5', 8, 2);
            $table->float('PM10', 8, 2);
            $table->float('Co', 8, 2);
            $table->float('Mo2', 8, 2);
            $table->float('Decibels', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('hardware_data');
        Schema::dropIfExists('hardware');        
        Schema::enableForeignKeyConstraints();
    }
};
