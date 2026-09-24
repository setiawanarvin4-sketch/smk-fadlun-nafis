<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPengganti extends Model
{
    protected $table = 'jadwal_pengganti';

    protected $fillable = ['guru_id', 'kelas_id', 'mata_pelajaran_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'keterangan'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function guru() { return $this->belongsTo(Guru::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
}