<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru_tidak_hadir', function (Blueprint $table) {
            $table->string('status')->default('Menunggu')->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('guru_tidak_hadir', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};