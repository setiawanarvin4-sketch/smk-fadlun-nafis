<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->unique(['guru_id', 'kelas_id', 'mata_pelajaran_id', 'tanggal'], 'sesi_unik');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->dropUnique('sesi_unik');
        });
    }
};