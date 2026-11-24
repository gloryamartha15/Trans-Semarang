<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_status_histories', function (Blueprint $table) {
            $table->id();

            // Aduan yang mengalami perubahan status.
            $table->foreignId('complaint_id')
                ->constrained('complaints')
                ->restrictOnDelete();

            // Petugas/Admin yang melakukan perubahan.
            // Nullable untuk perubahan yang dilakukan sistem.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('old_status', 50);
            $table->string('new_status', 50);

            // Wajib untuk Selesai dan Ditolak melalui validasi aplikasi.
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('new_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_status_histories');
    }
};
