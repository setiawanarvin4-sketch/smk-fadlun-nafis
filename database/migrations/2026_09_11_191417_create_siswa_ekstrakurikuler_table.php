<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikuler')->cascadeOnDelete();
            $table->enum('jenis', ['Wajib', 'Pilihan']);
            $table->timestamps();

            $table->unique(['siswa_id', 'ekstrakurikuler_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_ekstrakurikuler');
    }
};