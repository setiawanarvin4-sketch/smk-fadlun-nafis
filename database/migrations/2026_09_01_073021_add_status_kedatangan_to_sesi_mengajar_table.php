<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->string('status_kedatangan')->default('Tepat Waktu')->after('waktu_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->dropColumn('status_kedatangan');
        });
    }
};