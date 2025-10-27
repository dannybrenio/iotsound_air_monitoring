<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Hardware_data;

class HardwareDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Hardware_data::factory()->count(144)->create();
         // clears only this table


        $start = Carbon::now()->subHours(12); // starting point, e.g., 12 hours ago

        for ($i = 0; $i < 144; $i++) { // 144 records = 12 hours of 5-minute intervals
            Hardware_data::factory()->create([
                'realtime_stamp' => $start->copy()->addMinutes($i * 5),
            ]);
        }
    }
}
