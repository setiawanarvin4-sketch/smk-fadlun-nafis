<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Hitung rentang tanggal semester yang sedang berjalan.
 * Semester Ganjil: Juli - Januari. Semester Genap: Februari - Juni.
 * Logikanya dipindah ke sini dari Guru\Laporan::exportSemester() supaya bisa
 * dipakai juga di Portal Siswa tanpa duplikasi.
 */
class TahunAjaran
{
    /**
     * @return array{0: Carbon, 1: Carbon, 2: bool, 3: int} [$mulai, $selesai, $ganjil, $tahunAjaran]
     */
    public static function semesterBerjalan(): array
    {
        $p = \App\Models\PengaturanSitus::current();
        $bulanGanjil = $p->bulan_mulai_ganjil ?: 7;
        $bulanGenap = $p->bulan_mulai_genap ?: 1;

        $bulanSekarang = now()->month;
        $ganjil = $bulanSekarang >= $bulanGanjil;
        $tahunAjaran = $ganjil ? now()->year : now()->year - 1;

        if ($ganjil) {
            $mulai = Carbon::create($tahunAjaran, $bulanGanjil, 1);
            $selesai = Carbon::create($bulanGenap > $bulanGanjil ? $tahunAjaran : $tahunAjaran + 1, $bulanGenap, 1)->subDay();
        } else {
            $mulai = Carbon::create($tahunAjaran + 1, $bulanGenap, 1);
            $selesai = Carbon::create($tahunAjaran + 1, $bulanGanjil, 1)->subDay();
        }

        return [$mulai->startOfDay(), $selesai->endOfDay(), $ganjil, $tahunAjaran];
    }
}