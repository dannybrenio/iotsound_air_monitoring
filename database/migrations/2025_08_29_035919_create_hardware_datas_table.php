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
            //foreign key reference
            $table->unsignedBigInteger('hardware_id');  
            $table->foreign('hardware_id')->references('hardware_id')->on('hardware')->onDelete('cascade');
            $table->string("parameter_example");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_datas');
    }
};
