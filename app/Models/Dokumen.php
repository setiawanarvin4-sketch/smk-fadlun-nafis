<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $fillable = ['nama', 'kategori', 'file', 'deskripsi', 'tanggal', 'status_publik'];

    protected function casts(): array
    {
        return ['status_publik' => 'boolean', 'tanggal' => 'date'];
    }
}