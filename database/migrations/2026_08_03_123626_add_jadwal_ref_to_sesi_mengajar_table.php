<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->unsignedBigInteger('jadwal_pelajaran_id')->nullable()->after('mata_pelajaran_id');
            $table->unsignedBigInteger('jadwal_pengganti_id')->nullable()->after('jadwal_pelajaran_id');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->dropColumn(['jadwal_pelajaran_id', 'jadwal_pengganti_id']);
        });
    }
};