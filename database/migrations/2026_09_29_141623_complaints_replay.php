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
    Schema::create('complaints_replay', function (Blueprint $table) {
        $table->id();
        $table->foreignId('complaints_id')->nullable()->constrained('complaints')->nullOnDelete();
        $table->foreignId('id_petugas')->nullable()->constrained('users')->nullOnDelete();
        $table->longText('tanggapan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     Schema::dropIfExists('complaints_replay');
    }
};
