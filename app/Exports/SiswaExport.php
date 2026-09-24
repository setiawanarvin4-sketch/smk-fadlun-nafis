<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        protected ?int $kelasId = null,
        protected ?int $kompetensiId = null,
        protected ?int $tingkat = null,
    ) {}

    public function collection()
    {
        return Siswa::with(['kelas', 'kompetensi', 'ekstraWajib', 'ekstraPilihan'])
            ->when($this->kelasId, fn ($q) => $q->where('kelas_id', $this->kelasId))
            ->when($this->kompetensiId, fn ($q) => $q->where('kompetensi_id', $this->kompetensiId))
            ->when($this->tingkat, fn ($q) => $q->whereHas('kelas', fn ($k) => $k->where('tingkat', $this->tingkat)))
            ->orderBy('nama')
            ->get();
    }

    public function headings(): array
    {
        return ['Nama', 'NIS', 'NISN', 'Kelas', 'Kompetensi Keahlian', 'Jenis Kelamin', 'Status', 'Ekstra Wajib', 'Ekstra Pilihan'];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nama,
            $siswa->nis,
            $siswa->nisn,
            $siswa->kelas->nama_kelas ?? '-',
            $siswa->kompetensi->nama ?? '-',
            $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $siswa->aktif ? 'Aktif' : 'Nonaktif',
            $siswa->ekstraWajib->pluck('nama')->implode(', ') ?: '-',
            $siswa->ekstraPilihan->pluck('nama')->implode(', ') ?: '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}