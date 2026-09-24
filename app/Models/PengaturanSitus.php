<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSitus extends Model
{
    protected $table = 'pengaturan_situs';

        protected $fillable = [
        'logo', 'nama_sekolah', 'tagline', 'alamat', 'telepon', 'whatsapp', 'email', 'instagram',
        'facebook', 'youtube', 'tiktok', 'latitude', 'longitude', 'maintenance_mode',
        'wa_notifikasi_aktif', 'wa_gateway_token', 'wa_gateway_endpoint', 'tahun_ajaran_aktif',
    ];

    protected function casts(): array
    {
        return [
            'maintenance_mode' => 'boolean',
            'wa_notifikasi_aktif' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'nama_sekolah' => 'SMK Fadlun Nafis Bangsri',
        ]);
    }
}