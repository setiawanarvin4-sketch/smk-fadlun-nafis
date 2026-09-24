<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKehadiranSiswaExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?int $kelasId = null,
        protected ?int $bulan = null,
        protected ?int $tahun = null,
    ) {}

    public function headings(): array
    {
        return ['Nama', 'NIS', 'Kelas', 'Hadir', 'Izin', 'Sakit', 'Alpha'];
    }

    public function collection()
    {
        $bulan = $this->bulan ?? now()->month;
        $tahun = $this->tahun ?? now()->year;

        $rekapRaw = DB::table('absensi')
            ->join('siswa', 'siswa.id', '=', 'absensi.siswa_id')
            ->join('sesi_mengajar', 'sesi_mengajar.id', '=', 'absensi.sesi_mengajar_id')
            ->when($this->kelasId, fn ($q) => $q->where('siswa.kelas_id', $this->kelasId))
            ->whereMonth('sesi_mengajar.tanggal', $bulan)
            ->whereYear('sesi_mengajar.tanggal', $tahun)
            ->selectRaw('absensi.siswa_id, absensi.status, count(*) as total')
            ->groupBy('absensi.siswa_id', 'absensi.status')
            ->get()
            ->groupBy('siswa_id');

        return Siswa::with('kelas')
            ->when($this->kelasId, fn ($q) => $q->where('kelas_id', $this->kelasId))
            ->where('aktif', true)
            ->orderBy('nama')
            ->get()
            ->map(function ($s) use ($rekapRaw) {
                $counts = ($rekapRaw->get($s->id) ?? collect())->pluck('total', 'status');

                return [
                    $s->nama,
                    $s->nis,
                    $s->kelas->nama_kelas ?? '-',
                    $counts['Hadir'] ?? 0,
                    $counts['Izin'] ?? 0,
                    $counts['Sakit'] ?? 0,
                    $counts['Alpha'] ?? 0,
                ];
            });
    }
}