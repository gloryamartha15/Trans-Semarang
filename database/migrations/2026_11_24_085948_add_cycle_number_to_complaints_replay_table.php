<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom hanya jika belum tersedia.
        if (! Schema::hasColumn('complaints_replay', 'cycle_number')) {
            Schema::table('complaints_replay', function (Blueprint $table) {
                $table->unsignedInteger('cycle_number')
                    ->default(1)
                    ->after('id_petugas');
            });
        }

        // Pertahankan tanggapan lama sebagai data historis.
        DB::table('complaints_replay')
            ->where('id', 21)
            ->where('complaints_id', 15)
            ->update(['cycle_number' => 0]);

        // Pastikan tanggapan aktif tetap berada di siklus pertama.
        DB::table('complaints_replay')
            ->where('id', 22)
            ->where('complaints_id', 15)
            ->update(['cycle_number' => 1]);

        // Buat indeks unik jika belum tersedia.
        $indexExists = DB::select(
            "SHOW INDEX FROM complaints_replay
             WHERE Key_name = 'complaints_replay_cycle_unique'"
        );

        if (empty($indexExists)) {
            Schema::table('complaints_replay', function (Blueprint $table) {
                $table->unique(
                    ['complaints_id', 'cycle_number'],
                    'complaints_replay_cycle_unique'
                );
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('complaints_replay', 'cycle_number')) {
            $indexExists = DB::select(
                "SHOW INDEX FROM complaints_replay
                 WHERE Key_name = 'complaints_replay_cycle_unique'"
            );

            Schema::table('complaints_replay', function (Blueprint $table) use ($indexExists) {
                if (! empty($indexExists)) {
                    $table->dropUnique('complaints_replay_cycle_unique');
                }

                $table->dropColumn('cycle_number');
            });
        }
    }
};
