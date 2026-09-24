<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiadikInformation extends Model
{
    protected $table = 'siadik_informations';

    protected $fillable = ['deskripsi', 'galeri', 'url_siadik'];

    protected function casts(): array
    {
        return [
            'galeri' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], ['url_siadik' => '#']);
    }
}