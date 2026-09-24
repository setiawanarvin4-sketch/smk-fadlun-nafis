<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['nama_file', 'nama_asli', 'path', 'kategori', 'ukuran', 'tipe'];
}