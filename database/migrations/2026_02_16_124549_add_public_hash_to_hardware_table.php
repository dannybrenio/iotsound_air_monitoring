<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Backfill missing hashes (NULL or '')
        $rows = DB::table('hardware')
            ->select('hardware_id', 'public_hash')
            ->whereNull('public_hash')
            ->orWhere('public_hash', '')
            ->get();

        foreach ($rows as $row) {
            // generate a unique hash (retry if collision)
            do {
                $hash = Str::random(16); // 16 chars is enough; make 32 if you want
                $exists = DB::table('hardware')->where('public_hash', $hash)->exists();
            } while ($exists);

            DB::table('hardware')
                ->where('hardware_id', $row->hardware_id)
                ->update(['public_hash' => $hash]);
        }

        // 2) Add unique index if it doesn't exist yet
        Schema::table('hardware', function (Blueprint $table) {
            // name it so we can drop it reliably later
            $table->unique('public_hash', 'hardware_public_hash_unique');
        });
    }

    public function down(): void
    {
        Schema::table('hardware', function (Blueprint $table) {
            $table->dropUnique('hardware_public_hash_unique');
        });
    }
};
