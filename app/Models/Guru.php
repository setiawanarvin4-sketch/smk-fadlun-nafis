<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = ['user_id', 'nip', 'nama', 'foto', 'jabatan', 'bidang', 'nip_publik', 'aktif', 'no_wa'];

    public function sesiMengajar()
    {
        return $this->hasMany(SesiMengajar::class);
    }

    public function tidakHadir()
    {
        return $this->hasMany(GuruTidakHadir::class);
    }

    protected function casts(): array
    {
        return ['aktif' => 'boolean', 'nip_publik' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran');
    }

        public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }
}