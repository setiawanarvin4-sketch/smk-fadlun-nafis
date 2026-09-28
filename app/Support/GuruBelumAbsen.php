<?php

namespace App\Support;

use App\Models\GuruTidakHadir;
use App\Models\HariKhusus;
use App\Models\JadwalPelajaran;
use App\Models\SesiMengajar;
use Illuminate\Support\Collection;

class GuruBelumAbsen
{
    /**
     * Daftar jadwal hari ini yang jam pelajarannya sudah lewat tapi guru
     * belum isi absensi & belum lapor tidak hadir. Dipakai untuk badge
     * notifikasi (di AppServiceProvider) dan daftar rinci di Dashboard Admin.
     */
    public static function daftar(): Collection
    {
        $hariMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $hariMap[now()->dayOfWeek];
        $tanggalIni = now()->toDateString();
        $sekarang = now()->format('H:i:s');

        $sudahAda = SesiMengajar::where('tanggal', $tanggalIni)
            ->whereNotNull('jadwal_pelajaran_id')
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        $tidakHadir = GuruTidakHadir::where('tanggal', $tanggalIni)
            ->whereNotNull('jadwal_pelajaran_id')
            ->pluck('jadwal_pelajaran_id')
            ->toArray();

        $jamPulangHariIni = HariKhusus::jamPulang($tanggalIni);

        return JadwalPelajaran::where('hari', $hariIni)
            ->where('aktif', true)
            ->where('jam_selesai', '<=', $sekarang)
            ->with(['guru', 'kelas', 'mataPelajaran'])
            ->get()
            ->filter(fn ($j) => ! in_array($j->id, $sudahAda) && ! in_array($j->id, $tidakHadir))
            ->reject(fn ($j) => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni)
            ->values();
    }
}