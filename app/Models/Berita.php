<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'thumbnail', 'isi', 'ringkasan', 'kategori', 'user_id',
        'tanggal_publikasi', 'seo_title', 'seo_description', 'status',
    ];

    protected function casts(): array
    {
        return ['tanggal_publikasi' => 'datetime'];
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('tanggal_publikasi', '<=', now());
    }
}