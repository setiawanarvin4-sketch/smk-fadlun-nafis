<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';

    protected $fillable = ['guru_id', 'kelas_id', 'mata_pelajaran_id', 'hari', 'jam_mulai', 'jam_selesai', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function guru() { return $this->belongsTo(Guru::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
}