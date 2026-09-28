<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Bersih-bersih kolom yang sudah tidak dipakai:
 *
 * 1. selfie_masuk_path / selfie_pulang_path (sesi_mengajar) — sisa dari fitur
 *    "verifikasi absensi pakai selfie" yang sudah dibatalkan sebelum Portal Guru
 *    dirilis (Portal Guru sekarang cuma check-in tanpa foto). Tidak pernah diisi
 *    kode manapun, hanya membebani skema.
 * 2. retensi_selfie_hari / auto_delete_selfie (pengaturan_situs) — pasangan
 *    pengaturan untuk fitur selfie di atas, ikut tidak terpakai.
 * 3. link_ppdb (pengaturan_situs) — field duplikat dari PpdbInformation::url_ppdb_resmi
 *    yang sudah py sendiri di menu Admin > PPDB. Field ini malah menyebabkan bug:
 *    view Pengaturan punya `wire:model="link_ppdb"` padahal komponen Livewire-nya
 *    tidak pernah mendeklarasikan properti itu (lihat perbaikan pada
 *    resources/views/livewire/admin/pengaturan/index.blade.php).
 * 4. tema (pengaturan_situs) — kolom tema/theme switcher yang tidak pernah
 *    dipakai fillable atau view manapun.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->dropColumn(['selfie_masuk_path', 'selfie_pulang_path']);
        });

        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->dropColumn(['retensi_selfie_hari', 'auto_delete_selfie', 'link_ppdb', 'tema']);
        });
    }

    public function down(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->string('selfie_masuk_path')->nullable();
            $table->string('selfie_pulang_path')->nullable();
        });

        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->unsignedInteger('retensi_selfie_hari')->default(90);
            $table->boolean('auto_delete_selfie')->default(false);
            $table->string('link_ppdb')->nullable();
            $table->string('tema')->default('Navy Professional');
        });
    }
};
