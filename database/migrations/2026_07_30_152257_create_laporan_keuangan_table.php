<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file')->nullable();
            $table->enum('visibilitas', ['publik', 'internal'])->default('internal')->index();
            $table->date('tanggal')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};