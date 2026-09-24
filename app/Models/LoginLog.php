<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';

    protected $fillable = ['user_id', 'email', 'waktu', 'ip_address', 'status', 'user_agent'];

    protected function casts(): array
    {
        return ['waktu' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}