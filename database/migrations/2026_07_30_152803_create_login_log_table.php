<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('email')->nullable();
            $table->timestamp('waktu')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->enum('status', ['Berhasil', 'Gagal']);
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'waktu']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_log');
    }
};