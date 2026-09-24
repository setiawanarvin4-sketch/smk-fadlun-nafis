<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menandai hari tertentu sekolah pulang lebih awal dari jadwal biasa
    // (rapat mendadak, acara, dsb) — baik direncanakan maupun dadakan di hari itu juga.
    // Jam pelajaran yang mulainya setelah jam_pulang otomatis tidak dianggap
    // "belum diisi guru" dan tidak memicu reminder WA.
    public function up(): void
    {
        Schema::create('hari_khusus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->time('jam_pulang');
            $table->string('keterangan')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hari_khusus');
    }
};