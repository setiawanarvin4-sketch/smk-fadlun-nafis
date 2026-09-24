<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->text('visi')->nullable()->after('deskripsi');
            $table->text('misi')->nullable()->after('visi');
            $table->string('foto_kegiatan_1')->nullable()->after('foto');
            $table->string('foto_kegiatan_2')->nullable()->after('foto_kegiatan_1');
            $table->string('foto_kegiatan_3')->nullable()->after('foto_kegiatan_2');
        });
    }

    public function down(): void
    {
        Schema::table('ekstrakurikuler', function (Blueprint $table) {
            $table->dropColumn(['visi', 'misi', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3']);
        });
    }
};