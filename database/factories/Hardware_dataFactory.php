<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hardware_data;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hardware_data>
 */
class Hardware_dataFactory extends Factory
{

    protected $model = Hardware_data::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $minutes = 0; // static counter to increment each record
        $timestamp = Carbon::now()->subHours(12)->addMinutes($minutes);
        $minutes += 5; // advance by 5 minutes per record

        return [
            'hardware_id' => 1,
            'pm2_5' => $this->faker->randomFloat(2, 0, 150),
            'pm10' => $this->faker->randomFloat(2, 0, 200),
            'no2'  => $this->faker->randomFloat(2, 0, 120),
            'co'   => $this->faker->randomFloat(2, 0, 10),
            'decibels'   => $this->faker->randomFloat(2, 0, 120),
            'realtime_stamp' => $timestamp,
        ];
    }
}
