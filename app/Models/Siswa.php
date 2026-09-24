<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';

    protected $fillable = ['user_id', 'nama', 'nis', 'nisn', 'kelas_id', 'kompetensi_id', 'foto', 'jenis_kelamin', 'no_wa_wali', 'aktif','status_keluar', 'tanggal_keluar'];

    // Jaring pengaman: kolom ini tidak akan pernah ikut terkirim ke browser
    // lewat serialisasi model (Livewire snapshot, toArray, toJson, dsb),
    // walau suatu saat ada komponen baru yang lupa membatasi query-nya.
    protected $hidden = ['nisn', 'no_wa_wali'];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'tanggal_keluar' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kompetensi()
    {
        return $this->belongsTo(Kompetensi::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function ekstrakurikuler()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'siswa_ekstrakurikuler')
            ->withPivot('jenis')->withTimestamps();
    }

    public function ekstraWajib()
    {
        return $this->ekstrakurikuler()->wherePivot('jenis', 'Wajib');
    }

    public function ekstraPilihan()
    {
        return $this->ekstrakurikuler()->wherePivot('jenis', 'Pilihan');
    }
}