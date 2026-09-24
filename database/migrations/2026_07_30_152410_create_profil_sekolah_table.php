<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->id();
            $table->longText('profil')->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->string('motto')->nullable();
            $table->longText('struktur_organisasi')->nullable();
            $table->longText('info_tata_usaha')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolah');
    }
};