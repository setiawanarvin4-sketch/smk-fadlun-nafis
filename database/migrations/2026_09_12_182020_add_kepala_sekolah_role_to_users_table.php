<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            // SQLite (dipakai phpunit.xml untuk testing) tidak punya tipe ENUM asli
            // dan tidak menegakkan constraint ini, jadi aman di-skip di sana.
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'kepala_sekolah') DEFAULT 'admin'");
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru') DEFAULT 'admin'");
    }
};