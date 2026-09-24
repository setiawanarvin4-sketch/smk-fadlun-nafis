<?php

namespace App\Http\Middleware;

use App\Models\PengaturanSitus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $pengaturan = Cache::remember('pengaturan-situs', 3600, fn () => PengaturanSitus::current());

        if (! $pengaturan instanceof PengaturanSitus) {
            // Cache rusak/objek tidak lengkap (bisa terjadi saat unserialize dari cache
            // database/file) — buang cache lama, ambil ulang langsung dari database.
            Cache::forget('pengaturan-situs');
            $pengaturan = PengaturanSitus::current();
        }

        if ($pengaturan->maintenance_mode) {
            $userBebas = auth()->check() && in_array(auth()->user()->role, ['admin', 'kepala_sekolah', 'guru']);
            $routeBebas = $request->routeIs('login', 'login.store', 'guru.login', 'logout')
             || $request->is('portal-akses', 'guru/portal-akses');

            if (! $userBebas && ! $routeBebas) {
                return response()->view('maintenance', ['pengaturan' => $pengaturan], 503);
            }
        }

        return $next($request);
    }
}