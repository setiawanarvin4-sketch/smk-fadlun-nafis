<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('kategori', ['Akademik', 'Non-Akademik']);
            $table->string('tingkat')->nullable();
            $table->unsignedSmallInteger('tahun');
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->nullOnDelete();
            $table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->nullOnDelete();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index(['kategori', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};