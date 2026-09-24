<?php

namespace App\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use App\Models\Siswa;
use App\Models\LoginLog;

class LoginForm extends Component
{
    public string $nis = '';
    public string $password = '';
    public string $error = '';

    public function login()
    {
        $this->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = 'siswa-login:'.$this->nis.'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->error = 'Terlalu banyak percobaan. Coba lagi dalam beberapa menit.';
            return;
        }

        $siswa = Siswa::where('nis', $this->nis)->where('aktif', true)->first();

        if ($siswa && $siswa->user_id && Auth::attempt(['id' => $siswa->user_id, 'password' => $this->password])) {
            RateLimiter::clear($key);
            request()->session()->regenerate();

            LoginLog::create([
                'user_id' => $siswa->user_id,
                'email' => $siswa->user->email ?? null,
                'ip_address' => request()->ip(),
                'status' => 'Berhasil',
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('siswa.dashboard');
        }

        RateLimiter::hit($key, 60);

        LoginLog::create([
            'email' => $this->nis,
            'ip_address' => request()->ip(),
            'status' => 'Gagal',
            'user_agent' => request()->userAgent(),
        ]);

        $this->error = 'NIS atau password salah, atau akun belum dibuatkan Admin.';
    }

    public function render()
    {
        return view('livewire.siswa.login-form');
    }
}