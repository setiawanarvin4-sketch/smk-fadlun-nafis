<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';

    protected $fillable = ['judul', 'deskripsi', 'file', 'visibilitas', 'tanggal', 'status'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function scopePublik($query)
    {
        return $query->where('visibilitas', 'publik')->where('status', 'published');
    }
}