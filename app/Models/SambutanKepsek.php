<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SambutanKepsek extends Model
{
    protected $table = 'sambutan_kepsek';

    protected $fillable = ['foto', 'nama', 'jabatan', 'judul', 'isi'];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}