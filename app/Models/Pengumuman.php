<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul', 'deskripsi', 'label_atas', 'gambar', 'button_text', 'button_url', 'aktif',
    ];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}