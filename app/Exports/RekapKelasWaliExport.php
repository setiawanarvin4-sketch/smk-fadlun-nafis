<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapKelasWaliExport implements FromArray, WithHeadings, WithStyles
{
    public function __construct(private int $kelasId, private int $bulan, private int $tahun) {}

    public function array(): array
    {
        $rekapRaw = DB::table('absensi')
            ->join('siswa', 'siswa.id', '=', 'absensi.siswa_id')
            ->join('sesi_mengajar', 'sesi_mengajar.id', '=', 'absensi.sesi_mengajar_id')
            ->where('siswa.kelas_id', $this->kelasId)
            ->whereMonth('sesi_mengajar.tanggal', $this->bulan)
            ->whereYear('sesi_mengajar.tanggal', $this->tahun)
            ->selectRaw('absensi.siswa_id, absensi.status, count(*) as total')
            ->groupBy('absensi.siswa_id', 'absensi.status')
            ->get()
            ->groupBy('siswa_id');

        return \App\Models\Siswa::where('kelas_id', $this->kelasId)
            ->where('aktif', true)
            ->orderBy('nama')
            ->get()
            ->map(function ($s) use ($rekapRaw) {
                $counts = ($rekapRaw->get($s->id) ?? collect())->pluck('total', 'status');

                return [$s->nama, $s->nis, $counts['Hadir'] ?? 0, $counts['Izin'] ?? 0, $counts['Sakit'] ?? 0, $counts['Alpha'] ?? 0];
            })->toArray();
    }

    public function headings(): array
    {
        return ['Nama', 'NIS', 'Hadir', 'Izin', 'Sakit', 'Alpha'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}