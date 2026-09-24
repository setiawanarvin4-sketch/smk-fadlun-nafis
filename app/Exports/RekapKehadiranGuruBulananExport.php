<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKehadiranGuruBulananExport implements FromCollection, WithHeadings
{
    public function __construct(protected int $bulan, protected int $tahun) {}

    public function headings(): array
    {
        return ['Nama Guru', 'NIG', 'Total Sesi', 'Tepat Waktu', 'Terlambat', 'Izin', 'Sakit', 'Dinas Luar', 'Lainnya'];    }

    public function collection()
    {
        return Guru::where('aktif', true)->orderBy('nama')->get()->map(function ($g) {
            $sesi = $g->sesiMengajar()
                ->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->get();

            $tidakHadir = $g->tidakHadir()
                ->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->get();

            return [
                $g->nama,
                $g->nip,
                $sesi->count(),
                $sesi->where('status_kedatangan', 'Tepat Waktu')->count(),
                $sesi->where('status_kedatangan', 'Terlambat')->count(),
                $tidakHadir->where('alasan', 'Izin')->count(),
                $tidakHadir->where('alasan', 'Sakit')->count(),
                $tidakHadir->where('alasan', 'Dinas Luar')->count(),
                $tidakHadir->where('alasan', 'Lainnya')->count(),
            ];
        });
    }
}