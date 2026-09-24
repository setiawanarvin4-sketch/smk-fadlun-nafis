<?php

namespace App\Livewire\Auth;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class VerifyTwoFactor extends Component
{
    public string $kode = '';
    public string $error = '';
    public string $info = '';

    public function verifikasi()
    {
        $this->error = '';
        $user = Auth::user();
        $key = 'verify-2fa:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->error = 'Terlalu banyak percobaan salah. Coba lagi dalam beberapa menit, atau minta kode baru.';
            return;
        }

        if (! $user->two_factor_code || ! $user->two_factor_expires_at || now()->greaterThan($user->two_factor_expires_at)) {
            $this->error = 'Kode sudah kadaluarsa. Klik "Kirim ulang kode" di bawah.';
            return;
        }

        if ($this->kode !== $user->two_factor_code) {
            RateLimiter::hit($key, 300);

            $this->error = 'Kode salah. Coba periksa lagi email kamu.';
            return;
        }

        RateLimiter::clear($key);

        $user->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ])->save();

        session(['two_factor_passed' => true]);

        return redirect()->route('admin.dashboard');
    }

    public function kirimUlang()
    {
        $user = Auth::user();
        $key = 'resend-2fa:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->error = 'Terlalu sering minta kirim ulang. Coba lagi beberapa menit lagi.';
            return;
        }
        RateLimiter::hit($key, 120);

        $kodeBaru = (string) random_int(100000, 999999);
        $user->forceFill([
            'two_factor_code' => $kodeBaru,
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();

        Mail::to($user->email)->send(new TwoFactorCodeMail($kodeBaru, $user->name));

        $this->info = 'Kode baru sudah dikirim ke email kamu.';
        $this->error = '';
    }

    public function render()
    {
        return view('livewire.auth.verify-two-factor');
    }
}