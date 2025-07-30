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
        Schema::table('supirs', function (Blueprint $table) {
            Schema::table('supirs', function (Blueprint $table) {
                // Drop unique index dulu kalo ada
                $table->dropColumn('email');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supirs', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nama');
        });
    }
};
