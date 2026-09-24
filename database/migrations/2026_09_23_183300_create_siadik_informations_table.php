<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Halaman informasi SiAdik (sistem akademik resmi sekolah). Situs ini hanya
    // menampilkan penjelasan + link akses ke SiAdik, TIDAK ada fitur SiAdik
    // yang dibangun ulang di sini.
    public function up(): void
    {
        Schema::create('siadik_informations', function (Blueprint $table) {
            $table->id();
            $table->longText('deskripsi')->nullable();
            $table->json('galeri')->nullable();
            $table->string('url_siadik');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siadik_informations');
    }
};