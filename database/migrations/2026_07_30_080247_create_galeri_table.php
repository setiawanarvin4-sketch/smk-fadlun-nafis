<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file');
            $table->enum('kategori', ['Kegiatan Sekolah', 'Pembelajaran', 'PPLG', 'Farmasi', 'Prestasi', 'Event']);
            $table->boolean('aktif')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};