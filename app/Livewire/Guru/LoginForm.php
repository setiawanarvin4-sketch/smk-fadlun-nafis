<?php

namespace App\Livewire\Guru;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use App\Models\Guru;
use App\Models\LoginLog;

class LoginForm extends Component
{
    public string $nip = '';
    public string $password = '';
    public string $error = '';

    public function login()
    {
        $this->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

    if (\App\Models\BlockedIp::sedangDiblokir(request()->ip())) {
        $this->error = 'Akses dari alamat IP Anda telah diblokir sementara karena percobaan login mencurigakan. Hubungi admin sekolah untuk membuka blokir.';
        return;
    }

    $key = 'guru-login:'.$this->nip.'|'.request()->ip();
    $keyIp = 'guru-login-ip:'.request()->ip();

    if (RateLimiter::tooManyAttempts($keyIp, 20)) {
        \App\Models\BlockedIp::blokir(request()->ip(), 'Otomatis: lebih dari 20 percobaan login gagal dalam waktu singkat (Portal Guru).');
        $this->error = 'Akses dari alamat IP Anda telah diblokir sementara karena percobaan login mencurigakan. Hubungi admin sekolah untuk membuka blokir.';
        return;
    }

    if (RateLimiter::tooManyAttempts($key, 5)) {
        $this->error = 'Terlalu banyak percobaan. Coba lagi dalam beberapa menit.';
        return;
    }
        $guru = Guru::where('nip', $this->nip)->where('aktif', true)->first();

        if ($guru && Auth::attempt(['id' => $guru->user_id, 'password' => $this->password])) {
            RateLimiter::clear($key);
            request()->session()->regenerate();

            LoginLog::create([
                'user_id' => $guru->user_id,
                'email' => $guru->user->email ?? null,
                'ip_address' => request()->ip(),
                'status' => 'Berhasil',
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('dashboard');
        }

        RateLimiter::hit($key, 60);
        RateLimiter::hit($keyIp, 60);

        LoginLog::create([
            'email' => $this->nip,
            'ip_address' => request()->ip(),
            'status' => 'Gagal',
            'user_agent' => request()->userAgent(),
        ]);

        $this->error = 'NIG atau password salah.';
    }

    public function render()
    {
        return view('livewire.guru.login-form');
    }
}