<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['Contoh Nama Siswa', '1234567890', '0012345678', 'X APHP 1', 'L', 'Pramuka', 'Futsal, PMR'],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nis', 'nisn', 'nama_kelas', 'jenis_kelamin (L/P)', 'ekstra_wajib', 'ekstra_pilihan'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}