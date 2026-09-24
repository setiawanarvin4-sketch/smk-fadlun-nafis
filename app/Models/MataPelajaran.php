<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = ['nama', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran');
    }
}