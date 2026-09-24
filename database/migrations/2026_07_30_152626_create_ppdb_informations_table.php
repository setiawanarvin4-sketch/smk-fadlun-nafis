<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Hanya informasi PPDB + link eksternal. TIDAK ADA pendaftaran/akun calon siswa di sini.
    public function up(): void
    {
        Schema::create('ppdb_informations', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran')->nullable();
            $table->enum('status', ['Dibuka', 'Ditutup'])->default('Dibuka');
            $table->longText('jadwal')->nullable();
            $table->longText('persyaratan')->nullable();
            $table->longText('alur_pendaftaran')->nullable();
            $table->longText('informasi_biaya')->nullable();
            $table->string('kontak_panitia')->nullable();
            $table->longText('faq')->nullable();
            $table->string('banner')->nullable();
            $table->string('url_ppdb_resmi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_informations');
    }
};