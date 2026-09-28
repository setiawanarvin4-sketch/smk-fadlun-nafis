<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiMengajar extends Model
{
    protected $table = 'sesi_mengajar';

protected $fillable = [
    'guru_id', 'kelas_id', 'mata_pelajaran_id', 'jadwal_pelajaran_id', 'jadwal_pengganti_id',
    'materi', 'kegiatan', 'kendala',
    'tanggal', 'waktu_mulai', 'status_kedatangan', 'waktu_selesai',
];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function guru() { return $this->belongsTo(Guru::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function absensi() { return $this->hasMany(Absensi::class); }
}