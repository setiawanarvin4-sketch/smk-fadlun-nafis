<?php

namespace App\Exports;

use App\Models\SesiMengajar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected ?string $kelasId = null,
        protected ?string $guruId = null,
        protected ?string $tanggalMulai = null,
        protected ?string $tanggalSelesai = null,
    ) {}

    public function headings(): array
    {
        return ['Tanggal', 'Guru', 'Kelas', 'Mata Pelajaran', 'Jam Mulai', 'Jam Selesai', 'Status Kedatangan', 'Materi', 'Kegiatan', 'Kendala'];
    }

    public function collection()
    {
        return SesiMengajar::with(['guru', 'kelas', 'mataPelajaran'])
            ->when($this->kelasId, fn ($q) => $q->where('kelas_id', $this->kelasId))
            ->when($this->guruId, fn ($q) => $q->where('guru_id', $this->guruId))
            ->when($this->tanggalMulai, fn ($q) => $q->where('tanggal', '>=', $this->tanggalMulai))
            ->when($this->tanggalSelesai, fn ($q) => $q->where('tanggal', '<=', $this->tanggalSelesai))
            ->orderByDesc('tanggal')
            ->get()
            ->map(fn ($s) => [
                $s->tanggal->format('d/m/Y'),
                $s->guru->nama ?? '-',
                $s->kelas->nama_kelas ?? '-',
                $s->mataPelajaran->nama ?? '-',
                substr($s->waktu_mulai, 0, 5),
                $s->waktu_selesai ? substr($s->waktu_selesai, 0, 5) : '-',
                $s->status_kedatangan,
                $s->materi ?? '-',
                $s->kegiatan ?? '-',
                $s->kendala ?? '-',
            ]);
    }
}