<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('deskripsi')->constrained('users')->nullOnDelete();
        });
        Schema::table('galeri', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('urutan')->constrained('users')->nullOnDelete();
        });
        Schema::table('agenda', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('foto')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', fn (Blueprint $t) => $t->dropConstrainedForeignId('user_id'));
        Schema::table('galeri', fn (Blueprint $t) => $t->dropConstrainedForeignId('user_id'));
        Schema::table('agenda', fn (Blueprint $t) => $t->dropConstrainedForeignId('user_id'));
    }
};