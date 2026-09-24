<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto')->nullable();
            $table->foreignId('kompetensi_id')->nullable()->constrained('kompetensi')->nullOnDelete();
            $table->string('tahun_lulus')->nullable();
            $table->string('pekerjaan_sekarang')->nullable();
            $table->text('testimoni')->nullable();
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};