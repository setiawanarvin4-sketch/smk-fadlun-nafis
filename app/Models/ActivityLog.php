<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = ['user_id', 'role', 'aktivitas', 'modul', 'data_id', 'ip_address', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function catat(string $aktivitas, ?string $modul = null, ?int $dataId = null, string $status = 'Berhasil'): void
    {
        $user = auth()->user();

        static::create([
            'user_id' => $user?->id,
            'role' => $user?->role,
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'data_id' => $dataId,
            'ip_address' => request()->ip(),
            'status' => $status,
        ]);
    }
}