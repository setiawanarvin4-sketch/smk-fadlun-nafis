<?php

namespace App\Livewire\Guru;

use App\Models\SesiMengajar;
use App\Models\Guru;
use Livewire\Component;

class Laporan extends Component
{
    public string $bulan;

    public function mount()
    {
        $this->bulan = now()->format('Y-m');
    }

    public function exportSemester()
    {
        \App\Models\ActivityLog::catat('Export Rekap Semester', 'Laporan');
        $tahunAjaran = now()->month >= 7 ? now()->year : now()->year - 1;
        $semesterGanjil = now()->month >= 7 || now()->month <= 1;

        [$mulai, $selesai] = $semesterGanjil
            ? [\Carbon\Carbon::create($tahunAjaran, 7, 1), \Carbon\Carbon::create($tahunAjaran + 1, 1, 31)]
            : [\Carbon\Carbon::create($tahunAjaran + 1, 2, 1), \Carbon\Carbon::create($tahunAjaran + 1, 6, 30)];

        $guru = \App\Models\Guru::where('user_id', auth()->id())->firstOrFail();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapSemesterGuruExport($guru->id, $mulai, $selesai),
            'rekap-semester-'.$guru->nama.'-'.($semesterGanjil ? 'ganjil' : 'genap').'-'.$tahunAjaran.'.xlsx'
        );
    }

    public function render()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        [$tahun, $bulanAngka] = explode('-', $this->bulan);

        $sesi = SesiMengajar::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        return view('livewire.guru.laporan', [
            'guru' => $guru,
            'sesi' => $sesi,
            'totalSesi' => $sesi->count(),
            'tepatWaktu' => $sesi->where('status_kedatangan', 'Tepat Waktu')->count(),
            'terlambat' => $sesi->where('status_kedatangan', 'Terlambat')->count(),
            'namaBulan' => \Carbon\Carbon::parse($this->bulan.'-01')->translatedFormat('F Y'),
        ]);
    }
}