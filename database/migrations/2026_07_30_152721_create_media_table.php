<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->string('nama_asli')->nullable();
            $table->string('path');
            $table->enum('kategori', ['Hero', 'Berita', 'Galeri', 'Prestasi', 'Guru', 'Siswa', 'Kegiatan', 'Dokumen']);
            $table->unsignedBigInteger('ukuran')->default(0);
            $table->string('tipe')->nullable();
            $table->timestamps();

            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};