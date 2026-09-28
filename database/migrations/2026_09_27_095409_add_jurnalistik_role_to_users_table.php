<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function ($table) {
            $table->string('nama_pena')->nullable()->after('name');
        });

        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'kepala_sekolah', 'siswa', 'jurnalistik') DEFAULT 'admin'");
    }

    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('nama_pena');
        });
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'kepala_sekolah', 'siswa') DEFAULT 'admin'");
    }
};