<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->string('whatsapp')->nullable()->after('telepon');
            $table->string('tiktok')->nullable()->after('youtube');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->dropColumn(['whatsapp', 'tiktok']);
        });
    }
};