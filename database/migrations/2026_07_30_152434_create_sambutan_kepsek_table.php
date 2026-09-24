<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sambutan_kepsek', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('judul')->nullable();
            $table->longText('isi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sambutan_kepsek');
    }
};