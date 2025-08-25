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
        Schema::table('approvals', function (Blueprint $table) {
            $table->dropColumn('changes');
            $table->json('old_data')->nullable(false)->after('note')->default(json_encode([]));
            $table->json('new_data')->nullable(false)->after('old_data')->default(json_encode([]));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approvals', function (Blueprint $table) {
            $table->json('changes');
            $table->dropColumn(['old_data', 'new_data']);
        });
    }
};
