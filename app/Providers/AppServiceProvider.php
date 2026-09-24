<?php

namespace App\Providers;

use App\Models\MenuNavigasi;
use App\Models\PengaturanSitus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        \Illuminate\Support\Facades\Gate::define('kelola-data', fn ($user) => $user->role === 'admin');

        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.guest', 'guest-layout');

        $ambilMenu = function () {
            $ambil = fn () => MenuNavigasi::whereNull('parent_id')
                ->where('aktif', true)
                ->with(['children' => fn ($q) => $q->where('aktif', true)->orderBy('urutan')])
                ->orderBy('urutan')
                ->get();

            $data = Cache::remember('menu-navigasi-utama', 3600, $ambil);

            if (! $data instanceof Collection) {
                Cache::forget('menu-navigasi-utama');
                $data = $ambil();
            }

            return $data;
        };

        $ambilPengaturan = function () {
            $data = Cache::remember('pengaturan-situs', 3600, fn () => PengaturanSitus::current());

            if (! $data instanceof PengaturanSitus) {
                Cache::forget('pengaturan-situs');
                $data = PengaturanSitus::current();
            }

            return $data;
        };

        $ambilProfil = function () {
            $data = Cache::remember('profil-sekolah-hero', 3600, fn () => \App\Models\ProfilSekolah::current());

            if (! $data instanceof \App\Models\ProfilSekolah) {
                Cache::forget('profil-sekolah-hero');
                $data = \App\Models\ProfilSekolah::current();
            }

            return $data;
        };

        View::composer('components.layouts.public', function ($view) use ($ambilMenu, $ambilPengaturan) {
            $view->with('menuUtama', $ambilMenu())->with('pengaturan', $ambilPengaturan());
        });

        View::composer('components.page-hero', function ($view) use ($ambilProfil) {
            $view->with('profilHero', $ambilProfil());
        });

        View::composer(['components.layouts.admin', 'components.layouts.guru', 'components.layouts.auth', 'components.layouts.siswa'], function ($view) use ($ambilPengaturan) {
            $view->with('pengaturan', $ambilPengaturan());
        });
        View::composer('components.layouts.admin', function ($view) {
            $izinMenunggu = \App\Models\GuruTidakHadir::where('status', 'Menunggu')->count();
            $loginGagal = \App\Models\LoginLog::where('status', 'Gagal')
                ->where('waktu', '>=', now()->subDay())
                ->count();

            $hariMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hariIni = $hariMap[now()->dayOfWeek];
            $tanggalIni = now()->toDateString();
            $sekarang = now()->format('H:i:s');

            $sudahAda = \App\Models\SesiMengajar::where('tanggal', $tanggalIni)
                ->whereNotNull('jadwal_pelajaran_id')
                ->pluck('jadwal_pelajaran_id')
                ->toArray();

            $tidakHadir = \App\Models\GuruTidakHadir::where('tanggal', $tanggalIni)
                ->whereNotNull('jadwal_pelajaran_id')
                ->pluck('jadwal_pelajaran_id')
                ->toArray();

            // Kalau hari ini ditandai "hari khusus" (pulang cepat), jadwal yang mulainya
            // sudah lewat jam pulang tidak dihitung sebagai sesi terlewat.
            $jamPulangHariIni = \App\Models\HariKhusus::jamPulang($tanggalIni);

            $sesiTerlewat = \App\Models\JadwalPelajaran::where('hari', $hariIni)
                ->where('aktif', true)
                ->where('jam_selesai', '<=', $sekarang)
                ->get()
                ->filter(fn ($j) => ! in_array($j->id, $sudahAda) && ! in_array($j->id, $tidakHadir))
                ->reject(fn ($j) => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni)
                ->count();

            $view->with('notifAdmin', [
                'izinMenunggu' => $izinMenunggu,
                'loginGagal' => $loginGagal,
                'sesiTerlewat' => $sesiTerlewat,
                'total' => $izinMenunggu + $loginGagal + $sesiTerlewat,
            ]);
        });
    }
}