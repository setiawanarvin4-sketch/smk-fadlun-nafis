<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'nama_pena'];

    protected $hidden = ['password', 'remember_token', 'two_factor_code'];

    public function getNamaTampilanAttribute(): string
    {
        return $this->nama_pena ?: $this->name;
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
        ];
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }
}