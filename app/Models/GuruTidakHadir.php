<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruTidakHadir extends Model
{
    protected $table = 'guru_tidak_hadir';

    protected $fillable = ['guru_id', 'kelas_id', 'mata_pelajaran_id', 'jadwal_pelajaran_id', 'jadwal_pengganti_id', 'tanggal', 'alasan', 'keterangan', 'status'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function guru() { return $this->belongsTo(Guru::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
}