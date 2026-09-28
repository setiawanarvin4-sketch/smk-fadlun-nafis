<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BatasiAksesJurnalistik
{
    /**
     * Jurnalistik hanya boleh mengakses rute admin yang namanya ada di daftar
     * ini. Route lain (siswa, guru, keuangan, dst) otomatis ditolak untuk
     * role ini, tanpa perlu bongkar struktur grup route yang sudah ada.
     */
    private array $izin = [
        'admin.dashboard', 'admin.berita', 'admin.galeri', 'admin.prestasi',
        'admin.agenda', 'admin.hero-slider',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role === 'jurnalistik' && ! in_array($request->route()?->getName(), $this->izin, true)) {
            abort(403, 'Akun Jurnalistik tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}