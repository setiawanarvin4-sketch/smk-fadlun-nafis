<?php

namespace App\Livewire\Admin;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Berita;
use App\Models\Kompetensi;
use App\Models\Prestasi;
use App\Models\SesiMengajar;
use App\Models\GuruTidakHadir;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPengganti;
use App\Models\LoginLog;
use App\Models\PpdbInformation;
use App\Models\ActivityLog;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $hariMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $hariMap[now()->dayOfWeek];
        $tanggalIni = now()->toDateString();

        // ===== SESI HARI INI (rincian) =====
        $sesiHariIni = SesiMengajar::where('tanggal', $tanggalIni)->get();
        $totalJadwalHariIni = JadwalPelajaran::where('hari', $hariIni)->where('aktif', true)->count()
            + JadwalPengganti::where('tanggal', $tanggalIni)->count();

        $sesiTercatat = $sesiHariIni->count();
        $sesiTepatWaktu = $sesiHariIni->where('status_kedatangan', 'Tepat Waktu')->count();
        $sesiTerlambat = $sesiHariIni->where('status_kedatangan', 'Terlambat')->count();
        $sesiBelumMulai = max($totalJadwalHariIni - $sesiHariIni->count(), 0);

        // ===== KARTU PERLU TINDAKAN =====
        $izinMenunggu = GuruTidakHadir::where('status', 'Menunggu')->count();
        $loginGagal24Jam = LoginLog::where('status', 'Gagal')->where('waktu', '>=', now()->subDay())->count();
        $guruTanpaWa = \App\Models\Guru::where('aktif', true)->where(fn ($q) => $q->whereNull('no_wa')->orWhere('no_wa', ''))->count();
        $totalGuru = \App\Models\Guru::where('aktif', true)->count();
        $siswaTanpaWaWali = \App\Models\Siswa::where('aktif', true)->where(fn ($q) => $q->whereNull('no_wa_wali')->orWhere('no_wa_wali', ''))->count();
        $totalSiswa = \App\Models\Siswa::where('aktif', true)->count();
        $cronTerakhir = \Illuminate\Support\Facades\Cache::get('scheduler_heartbeat');
        $cronSehat = $cronTerakhir && \Carbon\Carbon::parse($cronTerakhir)->gt(now()->subMinutes(5));

        // ===== WIDGET BARU =====
        $guruBelumAbsen = \App\Support\GuruBelumAbsen::daftar();
        $guruTidakHadirHariIni = GuruTidakHadir::where('tanggal', $tanggalIni)
            ->where('status', 'Disetujui')
            ->with(['guru', 'kelas', 'mataPelajaran'])
            ->get();
        $agendaTerdekat = \App\Models\Agenda::akanDatang()->limit(3)->get();
        $hariKhususTerdekat = \App\Models\HariKhusus::where('tanggal', '>=', $tanggalIni)
            ->orderBy('tanggal')->limit(3)->get();

        // ===== GRAFIK TREN 7 HARI =====
        $trenAbsensi = collect(range(6, 0))->map(function ($i) {
            $tgl = now()->subDays($i);
            return [
                'label' => $tgl->translatedFormat('D'),
                'tanggal' => $tgl->toDateString(),
                'jumlah' => SesiMengajar::where('tanggal', $tgl->toDateString())->count(),
            ];
        });
        $maxTren = max($trenAbsensi->pluck('jumlah')->max(), 1);

        return view('livewire.admin.dashboard', [
            'jumlahSiswa' => Siswa::where('aktif', true)->count(),
            'jumlahGuru' => Guru::where('aktif', true)->count(),
            'jumlahBerita' => Berita::where('status', 'published')->count(),
            'jumlahKompetensi' => Kompetensi::where('aktif', true)->count(),
            'absenHariIni' => $sesiHariIni->count(),
            'aktivitasTerbaru' => ActivityLog::with('user')->orderByDesc('created_at')->limit(6)->get(),
            'cronTerakhir' => $cronTerakhir,
            'cronSehat' => $cronSehat,

            'sesiTercatat' => $sesiTercatat,
            'sesiTepatWaktu' => $sesiTepatWaktu,
            'sesiBelumMulai' => $sesiBelumMulai,
            'sesiTerlambat' => $sesiTerlambat,
            'totalJadwalHariIni' => $totalJadwalHariIni,

            'izinMenunggu' => $izinMenunggu,
            'loginGagal24Jam' => $loginGagal24Jam,
            'guruTanpaWa' => $guruTanpaWa,
            'totalGuru' => $totalGuru,
            'siswaTanpaWaWali' => $siswaTanpaWaWali,
            'totalSiswa' => $totalSiswa,
            'guruBelumAbsen' => $guruBelumAbsen,
            'guruTidakHadirHariIni' => $guruTidakHadirHariIni,
            'agendaTerdekat' => $agendaTerdekat,
            'hariKhususTerdekat' => $hariKhususTerdekat,

            'trenAbsensi' => $trenAbsensi,
            'maxTren' => $maxTren,

            'beritaTerbaru' => Berita::orderByDesc('tanggal_publikasi')->limit(3)->get(),
            'prestasiTerbaru' => Prestasi::orderByDesc('tahun')->orderByDesc('id')->limit(3)->get(),

            'ppdbStatus' => PpdbInformation::current()->status,
        ]);
    }
}