<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_situs', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('nama_sekolah')->default('SMK Fadlun Nafis Bangsri');
            $table->string('tagline')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('link_ppdb')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('tema')->default('Navy Professional');
            $table->unsignedInteger('retensi_selfie_hari')->default(90);
            $table->boolean('auto_delete_selfie')->default(false);
            $table->boolean('maintenance_mode')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_situs');
    }
};