<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->text('visi')->nullable()->after('deskripsi');
            $table->text('misi')->nullable()->after('visi');
            $table->text('profil_singkat')->nullable()->after('misi');
            $table->string('kepala_jurusan_nama')->nullable()->after('profil_singkat');
            $table->string('kepala_jurusan_jabatan')->nullable()->after('kepala_jurusan_nama');
            $table->string('kepala_jurusan_foto')->nullable()->after('kepala_jurusan_jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('kompetensi', function (Blueprint $table) {
            $table->dropColumn(['visi', 'misi', 'profil_singkat', 'kepala_jurusan_nama', 'kepala_jurusan_jabatan', 'kepala_jurusan_foto']);
        });
    }
};