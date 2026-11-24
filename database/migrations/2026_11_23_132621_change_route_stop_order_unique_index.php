<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('route_stop', function (Blueprint $table) {
            $table->dropUnique('route_stop_route_id_stop_order_unique');

            $table->index(['route_id', 'stop_order']);
        });
    }

    public function down(): void
    {
        Schema::table('route_stop', function (Blueprint $table) {
            $table->dropIndex('route_stop_route_id_stop_order_index');

            $table->unique(['route_id', 'stop_order']);
        });
    }
};
