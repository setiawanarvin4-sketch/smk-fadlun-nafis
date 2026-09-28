<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['Contoh Nama Guru', '199001012015011001', 'contoh.guru@sekolah.sch.id', 'Guru Mapel', 'Normatif', '081234567890', 'Matematika, Fisika'],
        ];
    }

    public function headings(): array
    {
        return ['nama', 'nip', 'email', 'jabatan', 'bidang', 'no_wa', 'mata_pelajaran'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}