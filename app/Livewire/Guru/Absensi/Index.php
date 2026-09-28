<?php

namespace App\Livewire\Guru\Absensi;

use App\Models\Siswa;
use App\Models\JadwalPelajaran;
use App\Models\JadwalPengganti;
use App\Models\SesiMengajar;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\GuruTidakHadir;
use App\Models\ActivityLog;
use Livewire\Component;

class Index extends Component
{
    public array $status = [];
    public ?Guru $guru = null;
    public string $error = '';
    public string $tahap = 'daftar'; // daftar | masuk | lengkap | tidak_hadir | ditolak
    public string $materi = '';
    public string $kegiatan = '';
    public string $kendala = '';

    public ?int $kelas_id = null;
    public ?int $mata_pelajaran_id = null;
    public ?int $sesiId = null;
    public ?string $sumberTipe = null;
    public ?int $sumberId = null;
    public string $jamMulaiTerpilih = '';
    public string $jamSelesaiTerpilih = '';
    public string $namaKelasTerpilih = '';
    public string $namaMapelTerpilih = '';

    public bool $showTidakHadirForm = false;
    public string $alasanTidakHadir = 'Sakit';
    public string $keteranganTidakHadir = '';

    public bool $modeEdit = false;
    public bool $bisaEdit = false;
    public string $statusTidakHadirTersimpan = '';
    public ?string $waktuSelesai = null;

    public function mount()
    {
        $this->guru = Guru::where('user_id', auth()->id())->firstOrFail();
    }

    public function daftarJadwalHariIni()
    {
        $guru = $this->guru;
        $hariMap = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $hariIni = $hariMap[now()->dayOfWeek];
        $tanggalIni = now()->toDateString();

        // Kunci sesi berdasarkan jadwal spesifik (bukan kelas+mapel saja), supaya
        // mapel yang sama di jam berbeda pada hari yang sama tetap dianggap sesi terpisah.
        $sudahDiisi = SesiMengajar::where('guru_id', $guru->id)
            ->where('tanggal', $tanggalIni)
            ->get()
            ->map(fn ($s) => $s->jadwal_pelajaran_id ? 'reguler-'.$s->jadwal_pelajaran_id : 'pengganti-'.$s->jadwal_pengganti_id)
            ->toArray();

        $tidakHadir = GuruTidakHadir::where('guru_id', $guru->id)
            ->where('tanggal', $tanggalIni)
            ->get()
            ->map(fn ($g) => $g->jadwal_pelajaran_id ? 'reguler-'.$g->jadwal_pelajaran_id : 'pengganti-'.$g->jadwal_pengganti_id)
            ->toArray();

        // Kalau hari ini ditandai Admin sebagai "hari khusus" (pulang cepat), jadwal
        // yang jam mulainya sudah lewat jam pulang itu ditandai 'diliburkan' — guru
        // tetap boleh mengisinya kalau memang sempat mengajar, tapi tidak wajib.
        $jamPulangHariIni = \App\Models\HariKhusus::jamPulang($tanggalIni);

        $reguler = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->where('aktif', true)
            ->get()
            ->map(fn ($j) => (object) [
                'tipe' => 'reguler', 'id' => $j->id, 'kelas_id' => $j->kelas_id,
                'kelas_nama' => $j->kelas->nama_kelas ?? '-', 'mapel_id' => $j->mata_pelajaran_id,
                'mapel_nama' => $j->mataPelajaran->nama ?? '-',
                'jam_mulai' => $j->jam_mulai, 'jam_selesai' => $j->jam_selesai,
                'sudah_diisi' => in_array('reguler-'.$j->id, $sudahDiisi),
                'tidak_hadir' => in_array('reguler-'.$j->id, $tidakHadir),
                'diliburkan' => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni,
            ]);

        $pengganti = JadwalPengganti::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('tanggal', $tanggalIni)
            ->get()
            ->map(fn ($j) => (object) [
                'tipe' => 'pengganti', 'id' => $j->id, 'kelas_id' => $j->kelas_id,
                'kelas_nama' => $j->kelas->nama_kelas ?? '-', 'mapel_id' => $j->mata_pelajaran_id,
                'mapel_nama' => $j->mataPelajaran->nama ?? '-',
                'jam_mulai' => $j->jam_mulai, 'jam_selesai' => $j->jam_selesai,
                'sudah_diisi' => in_array('pengganti-'.$j->id, $sudahDiisi),
                'tidak_hadir' => in_array('pengganti-'.$j->id, $tidakHadir),
                'diliburkan' => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni,
            ]);

        return $reguler->concat($pengganti)->sortBy('jam_mulai')->values();
    }

    public function pilihJadwal(string $tipe, int $id)
    {
        $this->error = '';
        $guru = $this->guru;

        $jadwal = $tipe === 'reguler'
            ? JadwalPelajaran::where('guru_id', $guru->id)->find($id)
            : JadwalPengganti::where('guru_id', $guru->id)->find($id);

        if (! $jadwal) {
            $this->error = 'Jadwal tidak ditemukan.';
            return;
        }

        $this->kelas_id = $jadwal->kelas_id;
        $this->mata_pelajaran_id = $jadwal->mata_pelajaran_id;
        $this->sumberTipe = $tipe;
        $this->sumberId = $id;
        $this->jamMulaiTerpilih = substr($jadwal->jam_mulai, 0, 5);
        $this->jamSelesaiTerpilih = substr($jadwal->jam_selesai, 0, 5);
        $this->namaKelasTerpilih = $jadwal->kelas->nama_kelas ?? '-';
        $this->namaMapelTerpilih = $jadwal->mataPelajaran->nama ?? '-';

        $sesiSudahAda = SesiMengajar::where('guru_id', $guru->id)
            ->where($tipe === 'reguler' ? 'jadwal_pelajaran_id' : 'jadwal_pengganti_id', $id)
            ->where('tanggal', now()->toDateString())
            ->exists();

        if (! $sesiSudahAda) {
            $sekarang = now()->format('H:i:s');
            if ($sekarang < $jadwal->jam_mulai) {
                $this->tahap = 'ditolak';
                $this->error = 'Belum waktunya untuk sesi ini. Absensi baru bisa diisi mulai jam '
                    .substr($jadwal->jam_mulai, 0, 5).'.';
                return;
            }
        }

        $this->cekStatusSesi();
    }

    private function cekStatusSesi(): void
    {
        $this->showTidakHadirForm = false;
        $this->modeEdit = false;

        $guru = $this->guru;
        $tanggal = now()->toDateString();

        $kolomSumber = $this->sumberTipe === 'reguler' ? 'jadwal_pelajaran_id' : 'jadwal_pengganti_id';

        $tidakHadir = GuruTidakHadir::where('guru_id', $guru->id)
            ->where($kolomSumber, $this->sumberId)
            ->where('tanggal', $tanggal)
            ->first();

        if ($tidakHadir) {
            $this->tahap = 'tidak_hadir';
            $this->statusTidakHadirTersimpan = $tidakHadir->status;
            return;
        }

        $sesi = SesiMengajar::where('guru_id', $guru->id)
            ->where($kolomSumber, $this->sumberId)
            ->where('tanggal', $tanggal)
            ->first();

        if (! $sesi) {
            $this->tahap = 'masuk';
            $this->sesiId = null;
            $this->materi = '';
            $this->kegiatan = '';
            $this->kendala = '';
            $this->status = [];
            foreach ($this->daftarSiswa() as $s) {
                $this->status[$s->id] = 'Hadir';
            }
        } else {
            $this->tahap = 'lengkap';
            $this->sesiId = $sesi->id;
            $this->muatStatusUntukEdit($sesi);
        }
    }

    private function batasWaktuEdit(SesiMengajar $sesi): ?\Carbon\Carbon
    {
        $jamSelesai = $sesi->jadwal_pelajaran_id
            ? JadwalPelajaran::find($sesi->jadwal_pelajaran_id)?->jam_selesai
            : JadwalPengganti::find($sesi->jadwal_pengganti_id)?->jam_selesai;

        return $jamSelesai
            ? \Carbon\Carbon::parse($sesi->tanggal->toDateString().' '.$jamSelesai)
            : null;
    }

    private function muatStatusUntukEdit(SesiMengajar $sesi): void
    {
        $this->materi = $sesi->materi ?? '';
        $this->kegiatan = $sesi->kegiatan ?? '';
        $this->kendala = $sesi->kendala ?? '';
        $this->waktuSelesai = $sesi->waktu_selesai;
        $this->status = Absensi::where('sesi_mengajar_id', $sesi->id)
            ->pluck('status', 'siswa_id')->toArray();

        $batasEdit = $this->batasWaktuEdit($sesi);
        $this->bisaEdit = $batasEdit && now()->lessThanOrEqualTo($batasEdit);
    }

    public function batalPilihJadwal()
    {
        $this->tahap = 'daftar';
        $this->error = '';
    }

    public function daftarSiswa()
    {
        if (! $this->kelas_id) return collect();

        return Siswa::where('kelas_id', $this->kelas_id)->where('aktif', true)->orderBy('nama')->get();
    }

    public function tandaiSemuaHadir()
    {
        foreach ($this->daftarSiswa() as $s) {
            $this->status[$s->id] = 'Hadir';
        }
    }

    private function kirimNotifAlpha(int $siswaId): void
    {
        $siswa = Siswa::find($siswaId);
        if ($siswa?->no_wa_wali) {
            $pesan = "Assalamu'alaikum, Bapak/Ibu wali murid.\n\n"
                ."Kami informasikan bahwa ananda *{$siswa->nama}* tidak hadir (Alpha) pada mata pelajaran "
                ."{$this->namaMapelTerpilih} hari ini, ".now()->translatedFormat('l, d F Y').".\n\n"
                .'Mohon konfirmasi ke wali kelas apabila ada keterangan. Terima kasih.';

            \App\Jobs\KirimNotifikasiAbsensi::dispatch($siswaId, $pesan);
        }
    }

    private function kirimRalatAlpha(int $siswaId, string $statusBaru): void
    {
        $siswa = Siswa::find($siswaId);
        if ($siswa?->no_wa_wali) {
            $pesan = "Assalamu'alaikum, Bapak/Ibu wali murid.\n\n"
                ."Mohon maaf, ada koreksi data kehadiran ananda *{$siswa->nama}* pada mata pelajaran "
                ."{$this->namaMapelTerpilih} hari ini, ".now()->translatedFormat('l, d F Y').". "
                ."Status yang benar adalah *{$statusBaru}*, bukan Alpha seperti pemberitahuan sebelumnya.\n\n"
                .'Mohon maaf atas kekeliruan ini. Terima kasih.';

            \App\Jobs\KirimNotifikasiAbsensi::dispatch($siswaId, $pesan);
        }
    }

    public function submit()
    {
        $this->error = '';

        $this->validate([
            'materi' => 'required|string|min:10',
            'kegiatan' => 'required|string|min:10',
        ], [
            'materi.required' => 'Materi yang diajarkan wajib diisi.',
            'materi.min' => 'Materi terlalu singkat, jelaskan sedikit lebih detail (minimal 10 karakter).',
            'kegiatan.required' => 'Kegiatan/metode pembelajaran wajib diisi.',
            'kegiatan.min' => 'Kegiatan terlalu singkat, jelaskan sedikit lebih detail (minimal 10 karakter).',
        ]);

        $sekarang = now()->format('H:i:s');
        $jadwal = $this->sumberTipe === 'reguler'
            ? JadwalPelajaran::find($this->sumberId)
            : JadwalPengganti::find($this->sumberId);

        if (! $jadwal || $sekarang < $jadwal->jam_mulai) {
            $this->tahap = 'ditolak';
            $this->error = 'Waktu untuk sesi ini belum berlaku.';
            return;
        }

        $batasToleransi = date('H:i:s', strtotime($jadwal->jam_mulai.' +15 minutes'));
        $statusKedatangan = $sekarang > $batasToleransi ? 'Terlambat' : 'Tepat Waktu';

        $guru = $this->guru;

        $sudahAda = SesiMengajar::where('guru_id', $guru->id)
            ->where($this->sumberTipe === 'reguler' ? 'jadwal_pelajaran_id' : 'jadwal_pengganti_id', $this->sumberId)
            ->where('tanggal', now()->toDateString())
            ->exists();

        if ($sudahAda) {
            $this->cekStatusSesi();
            return;
        }

        try {
            $sesi = SesiMengajar::create([
                'guru_id' => $guru->id,
                'kelas_id' => $this->kelas_id,
                'mata_pelajaran_id' => $this->mata_pelajaran_id,
                'jadwal_pelajaran_id' => $this->sumberTipe === 'reguler' ? $this->sumberId : null,
                'jadwal_pengganti_id' => $this->sumberTipe === 'pengganti' ? $this->sumberId : null,
                'materi' => $this->materi,
                'kegiatan' => $this->kegiatan,
                'kendala' => $this->kendala,
                'tanggal' => now()->toDateString(),
                'waktu_mulai' => now()->toTimeString(),
                'status_kedatangan' => $statusKedatangan,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->cekStatusSesi();
            return;
        }

        foreach ($this->status as $siswaId => $statusKehadiran) {
            Absensi::create([
                'sesi_mengajar_id' => $sesi->id,
                'siswa_id' => $siswaId,
                'status' => $statusKehadiran,
            ]);

            if ($statusKehadiran === 'Alpha') {
                $this->kirimNotifAlpha((int) $siswaId);
            }
        }

        ActivityLog::catat('Mengisi Absensi', 'Absensi', $sesi->id);

        $this->tahap = 'lengkap';
        $this->sesiId = $sesi->id;
        $this->muatStatusUntukEdit($sesi->fresh());
    }

    public function updateStatusSiswa(int $siswaId, string $statusBaru)
    {
        if (! $this->sesiId || ! in_array($statusBaru, ['Hadir', 'Izin', 'Sakit', 'Alpha'])) {
            return;
        }

        $guru = $this->guru;

        $sesi = SesiMengajar::where('id', $this->sesiId)->where('guru_id', $guru->id)->first();
        if (! $sesi) return;

        $batasEdit = $this->batasWaktuEdit($sesi);

        if (! $batasEdit || now()->greaterThan($batasEdit)) {
            $this->error = 'Waktu untuk meralat absensi sudah habis (jam pelajaran ini sudah berakhir).';
            $this->bisaEdit = false;
            return;
        }

        $siswaValid = Siswa::where('id', $siswaId)
            ->where('kelas_id', $sesi->kelas_id)
            ->exists();

        if (! $siswaValid) {
            $this->error = 'Siswa tidak ditemukan di kelas sesi ini.';
            return;
        }
        
        $absensi = Absensi::firstOrNew([
            'sesi_mengajar_id' => $this->sesiId,
            'siswa_id' => $siswaId,
        ]);

        $statusLama = $absensi->status;
        $absensi->status = $statusBaru;
        $absensi->save();
        $this->status[$siswaId] = $statusBaru;

        if ($statusBaru === 'Alpha' && $statusLama !== 'Alpha') {
            $this->kirimNotifAlpha($siswaId);
        } elseif ($statusLama === 'Alpha' && $statusBaru !== 'Alpha') {
            $this->kirimRalatAlpha($siswaId, $statusBaru);
        }

        ActivityLog::catat('Meralat Absensi Siswa', 'Absensi', $this->sesiId);
    }

    public function simpanJurnal()
    {
        if (! $this->sesiId) return;

        $guru = $this->guru;

        SesiMengajar::where('id', $this->sesiId)->where('guru_id', $guru->id)->update([
            'materi' => $this->materi,
            'kegiatan' => $this->kegiatan,
            'kendala' => $this->kendala,
        ]);
    }

    /**
     * Tandai sesi sebagai selesai diajar. Ini yang sebelumnya hilang —
     * sesi mengajar tidak pernah punya cara untuk ditutup, jadi status di
     * dashboard selalu "Sedang Mengajar" selamanya.
     */
    public function selesaiMengajar()
    {
        if (! $this->sesiId) return;

        $guru = $this->guru;

        $sesi = SesiMengajar::where('id', $this->sesiId)->where('guru_id', $guru->id)->first();
        if (! $sesi || $sesi->waktu_selesai) return;

        if ($sesi->waktu_mulai && now()->format('H:i:s') < $sesi->waktu_mulai) {
            $this->error = 'Belum bisa menyelesaikan sesi sebelum waktu mulai.';
            return;
        }

        $sesi->update(['waktu_selesai' => now()->toTimeString()]);
        $this->waktuSelesai = $sesi->waktu_selesai;

        ActivityLog::catat('Menyelesaikan Sesi Mengajar', 'Absensi', $sesi->id);
        $this->dispatch('notify', message: 'Sesi mengajar ditandai selesai.', type: 'success');
    }

    public function simpanTidakHadir()
    {
        $this->validate(['alasanTidakHadir' => 'required|in:Sakit,Izin,Dinas Luar,Lainnya']);

        $guru = $this->guru;
        $kolomSumber = $this->sumberTipe === 'reguler' ? 'jadwal_pelajaran_id' : 'jadwal_pengganti_id';

        $existing = GuruTidakHadir::where('guru_id', $guru->id)
            ->where($kolomSumber, $this->sumberId)
            ->where('tanggal', now()->toDateString())
            ->first();

        if ($existing) {
            $this->tahap = 'tidak_hadir';
            $this->statusTidakHadirTersimpan = $existing->status;
            $this->showTidakHadirForm = false;
            return;
        }

        GuruTidakHadir::create([
            'guru_id' => $guru->id,
            'kelas_id' => $this->kelas_id,
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'jadwal_pelajaran_id' => $this->sumberTipe === 'reguler' ? $this->sumberId : null,
            'jadwal_pengganti_id' => $this->sumberTipe === 'pengganti' ? $this->sumberId : null,
            'tanggal' => now()->toDateString(),
            'alasan' => $this->alasanTidakHadir,
            'keterangan' => $this->keteranganTidakHadir,
        ]);

        ActivityLog::catat('Guru Tidak Hadir Mengajar', 'Absensi', $this->kelas_id);

        $this->tahap = 'tidak_hadir';
        $this->statusTidakHadirTersimpan = 'Menunggu';
        $this->showTidakHadirForm = false;
    }

    public function render()
    {
        return view('livewire.guru.absensi.index', [
            'jadwalHariIni' => $this->daftarJadwalHariIni(),
            'siswaList' => $this->daftarSiswa(),
        ]);
    }
}