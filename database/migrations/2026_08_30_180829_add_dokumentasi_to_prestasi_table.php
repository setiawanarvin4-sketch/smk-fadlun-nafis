<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->string('penyelenggara')->nullable()->after('tingkat');
            $table->string('foto_sertifikat')->nullable()->after('foto');
            $table->string('foto_dokumentasi')->nullable()->after('foto_sertifikat');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['penyelenggara', 'foto_sertifikat', 'foto_dokumentasi']);
        });
    }
};