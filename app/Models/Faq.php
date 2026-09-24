<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';

    protected $fillable = ['pertanyaan', 'jawaban', 'kategori', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}