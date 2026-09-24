<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = ['judul', 'kategori', 'tingkat', 'penyelenggara', 'tahun', 'siswa_id', 'kompetensi_id', 'foto', 'foto_sertifikat', 'foto_dokumentasi', 'deskripsi'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class);
    }
}