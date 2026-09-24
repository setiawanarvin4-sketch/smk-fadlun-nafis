<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->string('tahun_ajaran_aktif')->nullable();
        });

        $tahunSekarang = now()->month >= 7 ? now()->year.'/'.(now()->year + 1) : (now()->year - 1).'/'.now()->year;
        \Illuminate\Support\Facades\DB::table('pengaturan_situs')->update(['tahun_ajaran_aktif' => $tahunSekarang]);
    }

    public function down(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->dropColumn('tahun_ajaran_aktif');
        });
    }
};