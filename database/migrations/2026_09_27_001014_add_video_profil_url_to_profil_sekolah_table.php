<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom untuk menyimpan link video profil sekolah (YouTube dsb),
     * dikelola admin lewat halaman Profil Sekolah, ditampilkan di Beranda.
     */
    public function up(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            $table->string('video_profil_url')->nullable()->after('header_gambar');
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolah', function (Blueprint $table) {
            $table->dropColumn('video_profil_url');
        });
    }
};