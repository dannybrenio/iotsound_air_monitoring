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
        // Optional: clear just this table first
        // \DB::table('hardware_data')->truncate();

        $end   = Carbon::now()->startOfMinute();
        $start = (clone $end)->subMonthsNoOverflow(2);

        // total 5-minute steps from $start up to and including $end
        $total = intdiv($start->diffInMinutes($end), 5) + 1;

        Hardware_data::factory()
            ->count($total)
            ->sequence(fn ($seq) => [
                'realtime_stamp' => (clone $start)->addMinutes($seq->index * 5),
            ])
            ->create();
    }
}
