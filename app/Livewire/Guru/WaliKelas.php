<?php

namespace App\Livewire\Guru;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SesiMengajar;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WaliKelas extends Component
{
    public ?int $bulan = null;
    public ?int $tahun = null;
    public ?int $detailSiswaId = null;

    public function mount()
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    public function lihatDetail(int $siswaId)
    {
        $this->detailSiswaId = $siswaId;
    }

    public function tutupDetail()
    {
        $this->detailSiswaId = null;
    }

    public function exportRekap()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->firstOrFail();

        \App\Models\ActivityLog::catat('Export Rekap Kelas (Wali Kelas)', 'WaliKelas', $kelas->id);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapKelasWaliExport($kelas->id, $this->bulan, $this->tahun),
            'rekap-kelas-'.$kelas->nama_kelas.'-'.$this->bulan.'-'.$this->tahun.'.xlsx'
        );
    }

    public function render()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();

        $rekap = collect();
        $jurnalTerbaru = collect();
        $detailAbsensi = collect();

        if ($kelas) {
            $rekapRaw = DB::table('absensi')
                ->join('siswa', 'siswa.id', '=', 'absensi.siswa_id')
                ->join('sesi_mengajar', 'sesi_mengajar.id', '=', 'absensi.sesi_mengajar_id')
                ->where('siswa.kelas_id', $kelas->id)
                ->whereMonth('sesi_mengajar.tanggal', $this->bulan)
                ->whereYear('sesi_mengajar.tanggal', $this->tahun)
                ->selectRaw('absensi.siswa_id, absensi.status, count(*) as total')
                ->groupBy('absensi.siswa_id', 'absensi.status')
                ->get()
                ->groupBy('siswa_id');

            $rekap = Siswa::where('kelas_id', $kelas->id)
                ->where('aktif', true)
                ->orderBy('nama')
                ->get()
                ->map(function ($s) use ($rekapRaw) {
                    $counts = ($rekapRaw->get($s->id) ?? collect())->pluck('total', 'status');

                    return (object) [
                        'id' => $s->id,
                        'nama' => $s->nama,
                        'hadir' => $counts['Hadir'] ?? 0,
                        'izin' => $counts['Izin'] ?? 0,
                        'sakit' => $counts['Sakit'] ?? 0,
                        'alpha' => $counts['Alpha'] ?? 0,
                    ];
                });

            $jurnalTerbaru = SesiMengajar::with('mataPelajaran')
                ->where('kelas_id', $kelas->id)
                ->whereMonth('tanggal', $this->bulan)
                ->whereYear('tanggal', $this->tahun)
                ->orderByDesc('tanggal')
                ->limit(15)
                ->get();

            if ($this->detailSiswaId) {
                $detailAbsensi = Absensi::with('sesiMengajar.mataPelajaran')
                    ->where('siswa_id', $this->detailSiswaId)
                    ->whereHas('sesiMengajar', fn ($q) => $q
                        ->whereMonth('tanggal', $this->bulan)
                        ->whereYear('tanggal', $this->tahun))
                    ->get()
                    ->sortByDesc(fn ($a) => $a->sesiMengajar->tanggal);
            }
        }

        return view('livewire.guru.wali-kelas', [
            'kelas' => $kelas,
            'rekap' => $rekap,
            'jurnalTerbaru' => $jurnalTerbaru,
            'detailAbsensi' => $detailAbsensi,
            'detailSiswaNama' => $this->detailSiswaId ? Siswa::find($this->detailSiswaId)?->nama : null,
        ]);
    }
}