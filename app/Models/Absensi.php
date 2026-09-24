<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = ['sesi_mengajar_id', 'siswa_id', 'status'];

    public function sesiMengajar() { return $this->belongsTo(SesiMengajar::class); }
    public function siswa() { return $this->belongsTo(Siswa::class); }
}