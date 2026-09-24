<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('tahun_ajaran')->nullable()->after('tingkat');
        });

        // Isi tahun ajaran default untuk kelas yang sudah ada, supaya sistem tetap jalan normal
        $tahunSekarang = now()->month >= 7 ? now()->year.'/'.(now()->year + 1) : (now()->year - 1).'/'.now()->year;
        \Illuminate\Support\Facades\DB::table('kelas')->whereNull('tahun_ajaran')->update(['tahun_ajaran' => $tahunSekarang]);

        Schema::table('kelas', function (Blueprint $table) {
            $table->dropUnique(['nama_kelas']);
            $table->unique(['nama_kelas', 'tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropUnique(['nama_kelas', 'tahun_ajaran']);
            $table->unique(['nama_kelas']);
            $table->dropColumn('tahun_ajaran');
        });
    }
};