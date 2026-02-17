<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FillMissingHardwareDataSeeder extends Seeder
{
    private int $hardwareId = 1;
    private string $table = 'hardware_data'; // change if needed

    public function run(): void
    {
        $csvPath = storage_path('app/seed/aqi-filled-2025-11-01_to_2026-01-19-with-aqi-daynight.csv');

        if (!file_exists($csvPath)) {
            $this->command?->error("CSV not found: {$csvPath}");
            return;
        }

        $file = new \SplFileObject($csvPath);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);

        // Read header once
        $headers = $file->fgetcsv();
        if (!$headers || $headers === [null]) {
            $this->command?->error("CSV header missing/invalid.");
            return;
        }

        // Trim + remove UTF-8 BOM if present
        $headers = array_map(function ($h) {
            $h = trim((string)$h);
            $h = preg_replace('/^\xEF\xBB\xBF/', '', $h); // strip BOM
            return $h;
        }, $headers);

        $idx = array_flip($headers);

        $required = ['reading_timestamp','pm2_5_raw','pm10_raw','co_raw','no2_raw','decibel_raw'];
        foreach ($required as $col) {
            if (!array_key_exists($col, $idx)) {
                $this->command?->error("Missing required CSV column: {$col}");
                return;
            }
        }

        $chunkSize = 1000;
        $buffer = [];
        $totalInserted = 0;
        $totalRead = 0;
        $totalSkipped = 0;

        foreach ($file as $row) {
            if (!$row || $row === [null]) continue;

            $tsRaw = isset($row[$idx['reading_timestamp']]) ? trim((string)$row[$idx['reading_timestamp']]) : '';

            // ✅ Skip header row if it shows up again
            if ($tsRaw === '' || strtolower($tsRaw) === 'reading_timestamp') {
                $totalSkipped++;
                continue;
            }

            // ✅ Only accept rows that look like "YYYY-MM-DD HH:MM:SS"
            // Your CSV uses: 2025-11-14 12:56:38
            if (!preg_match('/^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}$/', $tsRaw)) {
                $totalSkipped++;
                continue;
            }

            $totalRead++;

            // No timezone parsing needed; treat as plain datetime string
            $ts = Carbon::createFromFormat('Y-m-d H:i:s', $tsRaw, 'Asia/Manila')
                ->setSecond(21)                 // ✅ match your DB pattern
                ->format('Y-m-d H:i:s');

            $buffer[] = [
                'hardware_id'    => $this->hardwareId,
                'pm2_5'          => (float) ($row[$idx['pm2_5_raw']] ?? 0),
                'pm10'           => (float) ($row[$idx['pm10_raw']] ?? 0),
                'co'             => (float) ($row[$idx['co_raw']] ?? 0),
                'no2'            => (float) ($row[$idx['no2_raw']] ?? 0),
                'decibels'       => (float) ($row[$idx['decibel_raw']] ?? 0),
                'realtime_stamp' => $ts,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];

            if (count($buffer) >= $chunkSize) {
                $totalInserted += $this->insertMissingChunk($buffer);
                $buffer = [];
            }
        }

        if ($buffer) {
            $totalInserted += $this->insertMissingChunk($buffer);
        }

        $this->command?->info("Done. Read: {$totalRead}. Skipped: {$totalSkipped}. Inserted: {$totalInserted}.");
    }

    private function insertMissingChunk(array $rows): int
    {
        $timestamps = array_values(array_unique(array_map(fn ($r) => $r['realtime_stamp'], $rows)));

        $existing = DB::table($this->table)
            ->where('hardware_id', $this->hardwareId)
            ->whereIn('realtime_stamp', $timestamps)
            ->pluck('realtime_stamp')
            ->all();

        $existingSet = array_fill_keys($existing, true);

        $toInsert = array_values(array_filter($rows, fn ($r) => !isset($existingSet[$r['realtime_stamp']])));

        if (!$toInsert) return 0;

        DB::table($this->table)->insert($toInsert);
        return count($toInsert);
    }
}
