<?php

namespace App\Livewire\Guru;

use App\Models\SesiMengajar;
use App\Models\Guru;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public bool $showDetail = false;
    public ?SesiMengajar $detailSesi = null;
    public ?Guru $guru = null;

    public function mount()
    {
        $this->guru = Guru::where('user_id', auth()->id())->firstOrFail();

        if (session('info')) {
            $this->dispatch('notify', message: session('info'), type: 'success');
        }
    }

    public function openDetail(int $sesiId)
    {
        $sesi = SesiMengajar::with(['kelas', 'mataPelajaran', 'absensi.siswa'])
            ->where('guru_id', $this->guru->id)
            ->find($sesiId);

        if (! $sesi) return;

        $this->detailSesi = $sesi;
        $this->showDetail = true;
    }

    public function render()
    {
        $guru = $this->guru;

        $riwayat = SesiMengajar::with(['kelas', 'mataPelajaran', 'absensi'])
            ->where('guru_id', $guru->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai')
            ->paginate(10);

        $absenHariIni = SesiMengajar::where('guru_id', $guru->id)
            ->where('tanggal', now()->toDateString())
            ->count();

        $sesiBulanIni = SesiMengajar::where('guru_id', $guru->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $totalSesiBulanIni = $sesiBulanIni->count();
        $tepatWaktuBulanIni = $sesiBulanIni->where('status_kedatangan', 'Tepat Waktu')->count();
        $persenTepatWaktu = $totalSesiBulanIni ? round(($tepatWaktuBulanIni / $totalSesiBulanIni) * 100) : 0;

        return view('livewire.guru.dashboard', [
            'guru' => $guru,
            'riwayat' => $riwayat,
            'absenHariIni' => $absenHariIni,
            'totalKelas' => Kelas::where('tahun_ajaran', \App\Models\PengaturanSitus::current()->tahun_ajaran_aktif)->count(),
            'totalSesiBulanIni' => $totalSesiBulanIni,
            'persenTepatWaktu' => $persenTepatWaktu,
            'pengumumanGuru' => \App\Models\PengumumanGuru::where('aktif', true)->latest()->limit(3)->get(),
        ]);
    }
}