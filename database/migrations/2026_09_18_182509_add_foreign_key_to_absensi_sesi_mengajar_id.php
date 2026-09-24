<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreign('sesi_mengajar_id')->references('id')->on('sesi_mengajar')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['sesi_mengajar_id']);
        });
    }
};