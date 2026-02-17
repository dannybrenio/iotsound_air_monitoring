<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FetchWeather extends Command
{
    protected $signature = 'weather:fetch {--backfill : Fetch past 60 days of data (run once)}';
    protected $description = 'Fetch hourly weather data from Open-Meteo and store only missing hours';

    public function handle()
    {
        $lat = 14.6514;
        $lon = 120.97;

        // ✅ BACKFILL MODE (run once)
        if ($this->option('backfill')) {
            return $this->runBackfill($lat, $lon);
        }

        // ✅ NORMAL MODE (hourly incremental)
        return $this->runIncremental($lat, $lon);
    }

    private function runBackfill($lat, $lon)
    {
        $this->info("⏳ Running 60-day backfill...");

        $url = "https://archive-api.open-meteo.com/v1/archive?latitude=$lat&longitude=$lon&start_date=" .
            now()->subDays(60)->toDateString() .
            "&end_date=" . now()->toDateString() .
            "&hourly=temperature_2m,relative_humidity_2m,weather_code,windspeed_10m,winddirection_10m,pressure_msl,precipitation" .
            "&timezone=Asia/Manila";

        $response = Http::timeout(20)->get($url);

        if (!$response->successful()) {
            $this->error("❌ Backfill API failed!");
            $this->error("Response: " . $response->body());
            return;
        }

        $this->storeWeatherRows($response->json());

        $this->info("✅ Backfill complete.");
    }

    private function runIncremental($lat, $lon)
    {
        $latest = WeatherData::max('weather_timestamp');

        // ✅ If no data exists yet, fetch a small initial window (past 2 days + forecast)
        if (!$latest) {
            $this->info("⚠️ No weather data found. Fetching initial 2 days + forecast...");
            $url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&timezone=Asia/Manila" .
                "&hourly=temperature_2m,relative_humidity_2m,weather_code,windspeed_10m,winddirection_10m,pressure_msl,precipitation" .
                "&past_days=2&forecast_days=2";
        } else {
            $latest = Carbon::parse($latest)->addHour(); // next missing hour

            $start = $latest->toDateString();
            $end   = $latest->copy()->addDays(2)->toDateString(); // fetch 48 hrs forecast forward

            $this->info("✅ Fetching only missing hours from $start onward...");

            $url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon" .
                "&timezone=Asia/Manila" .
                "&hourly=temperature_2m,relative_humidity_2m,weather_code,windspeed_10m,winddirection_10m,pressure_msl,precipitation" .
                "&start_date=$start&end_date=$end";
        }

        $response = Http::timeout(20)->get($url);

        if (!$response->successful()) {
            $this->error("❌ Weather API failed!");
            $this->error("Response: " . $response->body());
            return;
        }

        $inserted = $this->storeWeatherRows($response->json());

        $this->info("✅ Weather update complete. Inserted/updated $inserted rows.");
        Log::info("✅ weather:fetch ran and inserted/updated $inserted rows at " . now());
    }

    private function storeWeatherRows(array $data)
    {
        $hourly = $data['hourly'] ?? null;

        if (!$hourly || !isset($hourly['time'])) {
            throw new \Exception("❌ Invalid weather data structure.");
        }

        $rows = [];

        foreach ($hourly['time'] as $i => $time) {
            $time = Carbon::parse($time)->format('Y-m-d H:i:s'); // ✅ normalize

            $rows[] = [
                'weather_timestamp' => $time,
                'temperature_2m' => $hourly['temperature_2m'][$i],
                'relative_humidity_2m' => $hourly['relative_humidity_2m'][$i],
                'windspeed_10m' => $hourly['windspeed_10m'][$i],
                'winddirection_10m' => $hourly['winddirection_10m'][$i],
                'pressure_msl' => $hourly['pressure_msl'][$i],
                'precipitation' => $hourly['precipitation'][$i],
                'weather_code' => $hourly['weather_code'][$i],
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }

        WeatherData::upsert(
            $rows,
            ['weather_timestamp'],
            [
                'temperature_2m',
                'relative_humidity_2m',
                'windspeed_10m',
                'winddirection_10m',
                'pressure_msl',
                'precipitation',
                'weather_code',
                'updated_at'
            ]
        );

        return count($rows);
    }
}
