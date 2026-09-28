<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RiwayatAbsensi extends Component
{
    public ?int $kelasId = null;
    public ?int $bulan = null;
    public ?int $tahun = null;

    public function mount()
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    public function render()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();

        $kelasSaya = Kelas::whereIn('id', JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id')->unique())
            ->orderBy('nama_kelas')
            ->get();

        if (! $this->kelasId && $kelasSaya->isNotEmpty()) {
            $this->kelasId = $kelasSaya->first()->id;
        }

        $rekap = collect();

        if ($this->kelasId) {
            $rekapRaw = DB::table('absensi')
                ->join('sesi_mengajar', 'sesi_mengajar.id', '=', 'absensi.sesi_mengajar_id')
                ->where('sesi_mengajar.guru_id', $guru->id)
                ->where('sesi_mengajar.kelas_id', $this->kelasId)
                ->whereMonth('sesi_mengajar.tanggal', $this->bulan)
                ->whereYear('sesi_mengajar.tanggal', $this->tahun)
                ->selectRaw('absensi.siswa_id, absensi.status, count(*) as total')
                ->groupBy('absensi.siswa_id', 'absensi.status')
                ->get()
                ->groupBy('siswa_id');

            $rekap = Siswa::where('kelas_id', $this->kelasId)
                ->where('aktif', true)
                ->orderBy('nama')
                ->get()
                ->map(function ($s) use ($rekapRaw) {
                    $counts = ($rekapRaw->get($s->id) ?? collect())->pluck('total', 'status');

                    return (object) [
                        'nama' => $s->nama,
                        'hadir' => $counts['Hadir'] ?? 0,
                        'izin' => $counts['Izin'] ?? 0,
                        'sakit' => $counts['Sakit'] ?? 0,
                        'alpha' => $counts['Alpha'] ?? 0,
                    ];
                });
        }

        return view('livewire.guru.riwayat-absensi', [
            'kelasSaya' => $kelasSaya,
            'rekap' => $rekap,
        ]);
    }
}