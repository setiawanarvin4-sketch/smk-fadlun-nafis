<?php

namespace App\Livewire\Admin\KenaikanKelas;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\PengaturanSitus;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public string $tahunAjaranBaru = '';
    public bool $showKonfirmasi = false;
    public ?array $ringkasanHasil = null;

    public function mount()
    {
        $pengaturan = PengaturanSitus::current();
        $tahunAktif = (int) substr($pengaturan->tahun_ajaran_aktif, 0, 4);
        $this->tahunAjaranBaru = ($tahunAktif + 1).'/'.($tahunAktif + 2);
    }

    public function bukaKonfirmasi()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses melakukan ini.');

        $this->validate(['tahunAjaranBaru' => 'required|regex:/^\d{4}\/\d{4}$/']);
        $this->showKonfirmasi = true;
    }

    public function proses()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses melakukan ini.');

        $pengaturan = PengaturanSitus::current();
        $tahunLama = $pengaturan->tahun_ajaran_aktif;

        $kelasBaruDibuat = 0;
        $siswaNaik = 0;
        $siswaLulus = 0;

        DB::transaction(function () use ($tahunLama, &$kelasBaruDibuat, &$siswaNaik, &$siswaLulus) {
            $kelasAktif = Kelas::where('tahun_ajaran', $tahunLama)->get();

            foreach ($kelasAktif as $kelasLama) {
                if ($kelasLama->tingkat >= 12) {
                    $siswaLulus += Siswa::where('kelas_id', $kelasLama->id)->where('aktif', true)->update([
                        'aktif' => false,
                        'status_keluar' => 'Lulus',
                        'tanggal_keluar' => now()->toDateString(),
                    ]);
                    continue;
                }

                $kelasBaru = Kelas::create([
                    'nama_kelas' => $this->naikkanNamaKelas($kelasLama->nama_kelas),
                    'kompetensi_id' => $kelasLama->kompetensi_id,
                    'tingkat' => $kelasLama->tingkat + 1,
                    'tahun_ajaran' => $this->tahunAjaranBaru,
                    'wali_kelas_id' => null,
                ]);
                $kelasBaruDibuat++;

                $siswaNaik += Siswa::where('kelas_id', $kelasLama->id)->where('aktif', true)
                    ->update(['kelas_id' => $kelasBaru->id]);
            }

            $pengaturan->update(['tahun_ajaran_aktif' => $this->tahunAjaranBaru]);
        });

        ActivityLog::catat('Proses Kenaikan Kelas: '.$tahunLama.' -> '.$this->tahunAjaranBaru, 'Kelas');

        $this->ringkasanHasil = [
            'kelas_baru' => $kelasBaruDibuat,
            'siswa_naik' => $siswaNaik,
            'siswa_lulus' => $siswaLulus,
        ];
        $this->showKonfirmasi = false;
    }

    private function naikkanNamaKelas(string $nama): string
    {
        if (str_starts_with($nama, 'XI ')) return 'XII '.substr($nama, 3);
        if (str_starts_with($nama, 'X ')) return 'XI '.substr($nama, 2);
        return $nama.' (cek nama, tidak terdeteksi otomatis)';
    }

    public function render()
    {
        $pengaturan = PengaturanSitus::current();

        return view('livewire.admin.kenaikan-kelas.index', [
            'tahunAktif' => $pengaturan->tahun_ajaran_aktif,
            'jumlahKelas10' => Kelas::where('tahun_ajaran', $pengaturan->tahun_ajaran_aktif)->where('tingkat', 10)->count(),
            'jumlahKelas11' => Kelas::where('tahun_ajaran', $pengaturan->tahun_ajaran_aktif)->where('tingkat', 11)->count(),
            'jumlahKelas12' => Kelas::where('tahun_ajaran', $pengaturan->tahun_ajaran_aktif)->where('tingkat', 12)->count(),
            'jumlahSiswaAktif' => Siswa::where('aktif', true)->count(),
            'jumlahAkanLulus' => Siswa::where('aktif', true)
                ->whereHas('kelas', fn ($q) => $q->where('tahun_ajaran', $pengaturan->tahun_ajaran_aktif)->where('tingkat', 12))
                ->count(),
        ]);
    }
}