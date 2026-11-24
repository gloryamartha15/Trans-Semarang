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
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->string('no_aduan')->unique();
        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('stop_id')->nullable()->constrained('stops')->nullOnDelete();
        $table->foreignId('bus_id')->nullable()->constrained('buses')->nullOnDelete();
        $table->foreignId('categories_id')->nullable()->constrained('categories')->nullOnDelete();
        $table->string('nama_pengadu')->nullable();
        $table->string('judul');
        $table->longText('isi_aduan');
        $table->string('dokumentasi')->nullable();
        $table->enum('status_aduan',['diajukan','ditanggapi','selesai','ditolak'])->default('diajukan');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     Schema::dropIfExists('complaints');
    }
};
