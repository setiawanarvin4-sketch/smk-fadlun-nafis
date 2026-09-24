<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->boolean('wa_notifikasi_aktif')->default(false)->after('whatsapp');
            $table->string('wa_gateway_token')->nullable()->after('wa_notifikasi_aktif');
            $table->string('wa_gateway_endpoint')->nullable()->after('wa_gateway_token');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_situs', function (Blueprint $table) {
            $table->dropColumn(['wa_notifikasi_aktif', 'wa_gateway_token', 'wa_gateway_endpoint']);
        });
    }
};