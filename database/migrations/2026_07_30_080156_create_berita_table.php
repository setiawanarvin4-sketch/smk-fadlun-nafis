<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('isi');
            $table->text('ringkasan')->nullable();
            $table->string('kategori')->default('Umum');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'tanggal_publikasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};