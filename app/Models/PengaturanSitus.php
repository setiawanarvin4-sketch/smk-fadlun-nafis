<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSitus extends Model
{
    protected $table = 'pengaturan_situs';

        protected $fillable = [
        'logo', 'nama_sekolah', 'tagline', 'alamat', 'telepon', 'whatsapp', 'email', 'instagram',
        'facebook', 'youtube', 'tiktok', 'latitude', 'longitude', 'maintenance_mode',
        'wa_notifikasi_aktif', 'wa_gateway_token', 'wa_gateway_endpoint', 'tahun_ajaran_aktif', 'bulan_mulai_ganjil', 'bulan_mulai_genap',
    ];

    protected function casts(): array
    {
        return [
            'maintenance_mode' => 'boolean',
            'wa_notifikasi_aktif' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            // Token API gateway WA sebelumnya plain text di database. Cast ini
            // mengenkripsi/mendekripsi otomatis; nilai lama sudah dienkripsi
            // lewat migrasi 2026_09_25_070100_enkripsi_wa_gateway_token.
            'wa_gateway_token' => 'encrypted',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'nama_sekolah' => 'SMK Fadlun Nafis Bangsri',
        ]);
    }
}