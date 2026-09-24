<?php

namespace App\Console\Commands;

use App\Models\JadwalPelajaran;
use App\Models\JadwalPengganti;
use App\Models\SesiMengajar;
use App\Models\GuruTidakHadir;
use App\Services\WhatsappService;
use Illuminate\Console\Command;

class IngatkanGuruBelumAbsen extends Command
{
    protected $signature = 'absensi:ingatkan-guru';
    protected $description = 'Kirim WA pengingat ke guru yang belum mengisi absensi/jurnal untuk jadwal hari ini';

    public function handle(): void
    {
        $hariMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIni = $hariMap[now()->dayOfWeek];
        $tanggalIni = now()->toDateString();
        $sekarang = now()->format('H:i:s');

        $sesiSudahAda = SesiMengajar::where('tanggal', $tanggalIni)->get()
            ->map(fn ($s) => $s->jadwal_pelajaran_id ? 'reguler-'.$s->jadwal_pelajaran_id : 'pengganti-'.$s->jadwal_pengganti_id)
            ->toArray();

        $tidakHadir = GuruTidakHadir::where('tanggal', $tanggalIni)->get()
            ->map(fn ($g) => $g->jadwal_pelajaran_id ? 'reguler-'.$g->jadwal_pelajaran_id : 'pengganti-'.$g->jadwal_pengganti_id)
            ->toArray();

        // Kalau hari ini ditandai "hari khusus" (pulang cepat), jadwal yang mulainya
        // sudah lewat jam pulang tidak perlu diingatkan — kelasnya memang tidak jadi.
        $jamPulangHariIni = \App\Models\HariKhusus::jamPulang($tanggalIni);

        $reguler = JadwalPelajaran::with(['guru', 'kelas', 'mataPelajaran'])
            ->where('hari', $hariIni)->where('aktif', true)
            ->where('jam_selesai', '<=', $sekarang)
            ->get()
            ->filter(fn ($j) => ! in_array('reguler-'.$j->id, $sesiSudahAda) && ! in_array('reguler-'.$j->id, $tidakHadir))
            ->reject(fn ($j) => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni);

        $pengganti = JadwalPengganti::with(['guru', 'kelas', 'mataPelajaran'])
            ->where('tanggal', $tanggalIni)
            ->where('jam_selesai', '<=', $sekarang)
            ->get()
            ->filter(fn ($j) => ! in_array('pengganti-'.$j->id, $sesiSudahAda) && ! in_array('pengganti-'.$j->id, $tidakHadir))
            ->reject(fn ($j) => $jamPulangHariIni && $j->jam_mulai >= $jamPulangHariIni);

        $terlewat = $reguler->concat($pengganti);

        $terkirim = 0;

        foreach ($terlewat->groupBy('guru_id') as $daftar) {
            $guru = $daftar->first()->guru;

            if (! $guru || ! $guru->no_wa) {
                continue;
            }

            $baris = $daftar->map(fn ($j) => "- {$j->kelas->nama_kelas} ({$j->mataPelajaran->nama}), {$j->jam_mulai}-{$j->jam_selesai}")->implode("\n");

            $pesan = "Assalamu'alaikum, Bapak/Ibu {$guru->nama}.\n\n"
                ."Kami informasikan ada jadwal mengajar hari ini yang belum diisi absensi/jurnalnya:\n{$baris}\n\n"
                .'Mohon segera dilengkapi lewat Portal Guru. Terima kasih.';

            WhatsappService::kirim($guru->no_wa, $pesan);
            $terkirim++;
        }

        $this->info("Pengingat terkirim ke {$terkirim} guru.");
    }
}