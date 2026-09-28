<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->unsignedTinyInteger('bulan_mulai_ganjil')->default(7)->after('tahun_ajaran_aktif');
            $table->unsignedTinyInteger('bulan_mulai_genap')->default(1)->after('bulan_mulai_ganjil');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->dropColumn(['bulan_mulai_ganjil', 'bulan_mulai_genap']);
        });
    }
};