<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $table = 'hero_sliders';

    protected $fillable = [
        'judul', 'deskripsi', 'badge', 'foto', 'button1_text', 'button1_url',
        'button2_text', 'button2_url', 'urutan', 'aktif',
    ];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}