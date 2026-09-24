<?php

namespace App\Exports;

use App\Models\SesiMengajar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapSemesterGuruExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected int $guruId,
        protected \Carbon\Carbon $mulai,
        protected \Carbon\Carbon $selesai,
    ) {}

    public function headings(): array
    {
        return ['Tanggal', 'Kelas', 'Mata Pelajaran', 'Jam Mulai', 'Status Kedatangan', 'Materi'];
    }

    public function collection()
    {
        return SesiMengajar::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $this->guruId)
            ->whereBetween('tanggal', [$this->mulai->toDateString(), $this->selesai->toDateString()])
            ->orderBy('tanggal')
            ->get()
            ->map(fn ($s) => [
                $s->tanggal->format('d/m/Y'),
                $s->kelas->nama_kelas ?? '-',
                $s->mataPelajaran->nama ?? '-',
                substr($s->waktu_mulai, 0, 5),
                $s->status_kedatangan,
                $s->materi,
            ]);
    }
}