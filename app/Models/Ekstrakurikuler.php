<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = ['nama', 'deskripsi', 'visi', 'misi', 'foto', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3', 'pembina', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}