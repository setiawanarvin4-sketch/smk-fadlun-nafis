<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFactorCodeMail;
use App\Models\LoginLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            LoginLog::create([
                'email' => $request->input('email'),
                'ip_address' => $request->ip(),
                'status' => 'Gagal',
                'user_agent' => $request->userAgent(),
            ]);

            throw $e;
        }

        $request->session()->regenerate();

        $user = Auth::user();

        LoginLog::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => $request->ip(),
            'status' => 'Berhasil',
            'user_agent' => $request->userAgent(),
        ]);

        // Admin & Kepala Sekolah: wajib verifikasi kode email sebelum benar-benar masuk
        // (harus konsisten dengan role yang dicek di EnsureTwoFactorVerified).
        if (in_array($user->role, ['admin', 'kepala_sekolah'], true)) {
            $kode = (string) random_int(100000, 999999);

            $user->forceFill([
                'two_factor_code' => $kode,
                'two_factor_expires_at' => now()->addMinutes(10),
            ])->save();

            session()->forget('two_factor_passed');

            try {
                Mail::to($user->email)->send(new TwoFactorCodeMail($kode, $user->name));
            } catch (\Throwable $e) {
                // Di lokal (MAIL_MAILER=log) ini tidak akan gagal — cuma jaga-jaga
                // kalau di hosting nanti SMTP belum diisi, biar tidak crash 500.
                report($e);
            }

            return redirect()->route('2fa.verify');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}