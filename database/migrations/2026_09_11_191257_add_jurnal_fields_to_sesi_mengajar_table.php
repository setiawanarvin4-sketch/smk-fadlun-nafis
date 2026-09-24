<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->text('kegiatan')->nullable()->after('materi');
            $table->text('kendala')->nullable()->after('kegiatan');
        });
    }

    public function down(): void
    {
        Schema::table('sesi_mengajar', function (Blueprint $table) {
            $table->dropColumn(['kegiatan', 'kendala']);
        });
    }
};