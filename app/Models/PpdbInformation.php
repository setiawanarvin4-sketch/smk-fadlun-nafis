<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbInformation extends Model
{
    protected $table = 'ppdb_informations';

    protected $fillable = [
        'tahun_ajaran', 'status', 'jadwal', 'persyaratan', 'alur_pendaftaran',
        'informasi_biaya', 'kontak_panitia', 'faq', 'banner', 'url_ppdb_resmi',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], ['url_ppdb_resmi' => '#']);
    }
}