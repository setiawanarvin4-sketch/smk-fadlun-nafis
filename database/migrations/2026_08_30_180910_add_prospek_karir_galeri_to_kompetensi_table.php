<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->text('prospek_karir')->nullable()->after('misi');
            $table->string('foto_kegiatan_1')->nullable()->after('foto');
            $table->string('foto_kegiatan_2')->nullable()->after('foto_kegiatan_1');
            $table->string('foto_kegiatan_3')->nullable()->after('foto_kegiatan_2');
        });
    }

    public function down(): void
    {
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->dropColumn(['prospek_karir', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3']);
        });
    }
};