<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikSekolah extends Model
{
    protected $table = 'statistik_sekolah';

    protected $fillable = ['label', 'nilai', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}