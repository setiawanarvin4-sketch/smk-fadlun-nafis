<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    protected $fillable = ['ip_address', 'alasan', 'diblokir_pada', 'dibuka_pada', 'dibuka_oleh'];

    protected function casts(): array
    {
        return ['diblokir_pada' => 'datetime', 'dibuka_pada' => 'datetime'];
    }

    public function pembuka()
    {
        return $this->belongsTo(User::class, 'dibuka_oleh');
    }

    public static function sedangDiblokir(string $ip): bool
    {
        return static::where('ip_address', $ip)->whereNull('dibuka_pada')->exists();
    }

    public static function blokir(string $ip, string $alasan): void
    {
        static::updateOrCreate(
            ['ip_address' => $ip],
            ['alasan' => $alasan, 'diblokir_pada' => now(), 'dibuka_pada' => null, 'dibuka_oleh' => null]
        );
    }
}