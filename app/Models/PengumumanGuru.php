<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanGuru extends Model
{
    protected $table = 'pengumuman_guru';

    protected $fillable = ['judul', 'isi', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}