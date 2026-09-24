<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariKhusus extends Model
{
    protected $table = 'hari_khusus';

    protected $fillable = ['tanggal', 'jam_pulang', 'keterangan', 'dibuat_oleh'];

    /**
     * Ambil jam pulang cepat untuk tanggal tertentu, kalau ada.
     * null berarti tidak ada penyesuaian untuk tanggal itu (hari biasa).
     */
    public static function jamPulang(string $tanggal): ?string
    {
        return static::where('tanggal', $tanggal)->value('jam_pulang');
    }
}