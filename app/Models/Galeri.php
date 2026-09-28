<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = ['judul', 'deskripsi', 'file', 'kategori', 'aktif', 'urutan', 'user_id'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}