<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_tidak_hadir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->unsignedBigInteger('mata_pelajaran_id')->nullable();
            $table->date('tanggal');
            $table->enum('alasan', ['Sakit', 'Izin', 'Dinas Luar', 'Lainnya']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_tidak_hadir');
    }
};