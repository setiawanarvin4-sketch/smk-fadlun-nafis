<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nis')->nullable()->unique();
            $table->string('nisn')->nullable()->unique();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('kompetensi_id')->constrained('kompetensi')->cascadeOnDelete();
            $table->string('foto')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['kelas_id', 'kompetensi_id', 'aktif']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};