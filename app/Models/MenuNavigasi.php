<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuNavigasi extends Model
{
    protected $table = 'menu_navigasi';

    protected $fillable = ['parent_id', 'label', 'url', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function parent()
    {
        return $this->belongsTo(MenuNavigasi::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuNavigasi::class, 'parent_id')->orderBy('urutan');
    }
}