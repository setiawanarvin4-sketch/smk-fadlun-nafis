<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('nilai');
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_sekolah');
    }
};