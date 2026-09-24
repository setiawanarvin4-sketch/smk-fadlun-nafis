<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    protected $fillable = ['profil', 'header_gambar', 'sejarah', 'visi', 'misi', 'motto', 'struktur_organisasi', 'info_tata_usaha'];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}