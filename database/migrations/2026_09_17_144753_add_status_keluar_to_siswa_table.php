<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->enum('status_keluar', ['Aktif', 'Lulus', 'Pindah', 'Keluar'])->default('Aktif')->after('aktif');
            $table->date('tanggal_keluar')->nullable()->after('status_keluar');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['status_keluar', 'tanggal_keluar']);
        });
    }
};