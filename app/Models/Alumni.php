<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $fillable = [
        'nama', 'foto', 'kompetensi_id', 'tahun_lulus', 'pekerjaan_sekarang', 'testimoni', 'aktif', 'urutan',
    ];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class);
    }
}