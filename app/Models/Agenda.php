<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';

    protected $fillable = ['judul', 'tanggal', 'jam', 'lokasi', 'deskripsi', 'foto'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function scopeAkanDatang($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString())->orderBy('tanggal');
    }
}