<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_mengajar_id');
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha']);
            $table->timestamps();

            $table->unique(['sesi_mengajar_id', 'siswa_id']);
            $table->index('sesi_mengajar_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};