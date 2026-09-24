<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $table = 'kompetensi';

        protected $fillable = ['nama', 'slug', 'foto', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3', 'deskripsi', 'urutan', 'aktif', 'visi', 'misi', 'prospek_karir', 'profil_singkat', 'kepala_jurusan_nama', 'kepala_jurusan_jabatan', 'kepala_jurusan_foto'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}