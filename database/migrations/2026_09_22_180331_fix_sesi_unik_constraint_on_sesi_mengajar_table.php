<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Bereskan dulu data duplikat yang mungkin sudah terlanjur ada
        //    (misal dari fitur "Tandai Selesai Mengajar" yang membuat baris baru,
        //    bukan meng-update baris sesi yang sudah ada) — SEBELUM constraint baru
        //    dipasang, supaya ALTER TABLE tidak gagal karena data yang sudah ada.
        $this->gabungkanDuplikat('jadwal_pelajaran_id');
        $this->gabungkanDuplikat('jadwal_pengganti_id');

        // 2) Constraint lama dihapus (aman dijalankan ulang: dicek dulu apakah
        //    index-nya masih ada, karena bisa saja sudah terhapus di percobaan
        //    migrate sebelumnya yang gagal di tengah jalan).
        if ($this->indexAda('sesi_mengajar', 'sesi_unik')) {
            Schema::table('sesi_mengajar', function (Blueprint $table) {
                $table->dropUnique('sesi_unik');
            });
        }

        if (! $this->indexAda('sesi_mengajar', 'sesi_unik_reguler')) {
            Schema::table('sesi_mengajar', function (Blueprint $table) {
                $table->unique(['jadwal_pelajaran_id', 'tanggal'], 'sesi_unik_reguler');
            });
        }

        if (! $this->indexAda('sesi_mengajar', 'sesi_unik_pengganti')) {
            Schema::table('sesi_mengajar', function (Blueprint $table) {
                $table->unique(['jadwal_pengganti_id', 'tanggal'], 'sesi_unik_pengganti');
            });
        }

        if (! $this->indexAda('guru_tidak_hadir', 'tidak_hadir_unik_reguler')) {
            Schema::table('guru_tidak_hadir', function (Blueprint $table) {
                $table->unique(['jadwal_pelajaran_id', 'tanggal'], 'tidak_hadir_unik_reguler');
            });
        }

        if (! $this->indexAda('guru_tidak_hadir', 'tidak_hadir_unik_pengganti')) {
            Schema::table('guru_tidak_hadir', function (Blueprint $table) {
                $table->unique(['jadwal_pengganti_id', 'tanggal'], 'tidak_hadir_unik_pengganti');
            });
        }
    }

    /**
     * Gabungkan baris sesi_mengajar yang ternyata punya kolom referensi jadwal
     * (jadwal_pelajaran_id ATAU jadwal_pengganti_id) + tanggal yang sama.
     * Baris yang dipertahankan: yang sudah ditandai selesai (waktu_selesai terisi),
     * kalau sama-sama belum/sudah, yang id-nya paling besar (paling baru) yang dipakai.
     * Data absensi dari baris yang dibuang dipindah ke baris yang dipertahankan;
     * kalau siswa yang sama sudah tercatat di baris yang dipertahankan, baris
     * duplikatnya dibuang (bukan double count).
     */
    private function gabungkanDuplikat(string $kolom): void
    {
        $grup = DB::table('sesi_mengajar')
            ->select($kolom, 'tanggal', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull($kolom)
            ->groupBy($kolom, 'tanggal')
            ->having('jumlah', '>', 1)
            ->get();

        foreach ($grup as $g) {
            $baris = DB::table('sesi_mengajar')
                ->where($kolom, $g->$kolom)
                ->where('tanggal', $g->tanggal)
                ->orderByDesc('waktu_selesai')
                ->orderByDesc('id')
                ->get();

            $acuan = $baris->first();

            foreach ($baris->skip(1) as $dup) {
                $siswaSudahAda = DB::table('absensi')
                    ->where('sesi_mengajar_id', $acuan->id)
                    ->pluck('siswa_id')
                    ->toArray();

                // pindahkan absensi siswa yang belum tercatat di sesi acuan
                DB::table('absensi')
                    ->where('sesi_mengajar_id', $dup->id)
                    ->whereNotIn('siswa_id', $siswaSudahAda)
                    ->update(['sesi_mengajar_id' => $acuan->id]);

                // sisanya (siswa yang sudah tercatat duluan di sesi acuan) dibuang
                DB::table('absensi')->where('sesi_mengajar_id', $dup->id)->delete();

                DB::table('sesi_mengajar')->where('id', $dup->id)->delete();
            }
        }
    }

    private function indexAda(string $tabel, string $namaIndex): bool
    {
        return collect(DB::select("SHOW INDEX FROM `{$tabel}` WHERE Key_name = ?", [$namaIndex]))->isNotEmpty();
    }

    public function down(): void
    {
        if ($this->indexAda('sesi_mengajar', 'sesi_unik_reguler')) {
            Schema::table('sesi_mengajar', fn (Blueprint $table) => $table->dropUnique('sesi_unik_reguler'));
        }
        if ($this->indexAda('sesi_mengajar', 'sesi_unik_pengganti')) {
            Schema::table('sesi_mengajar', fn (Blueprint $table) => $table->dropUnique('sesi_unik_pengganti'));
        }
        if (! $this->indexAda('sesi_mengajar', 'sesi_unik')) {
            Schema::table('sesi_mengajar', function (Blueprint $table) {
                $table->unique(['guru_id', 'kelas_id', 'mata_pelajaran_id', 'tanggal'], 'sesi_unik');
            });
        }

        if ($this->indexAda('guru_tidak_hadir', 'tidak_hadir_unik_reguler')) {
            Schema::table('guru_tidak_hadir', fn (Blueprint $table) => $table->dropUnique('tidak_hadir_unik_reguler'));
        }
        if ($this->indexAda('guru_tidak_hadir', 'tidak_hadir_unik_pengganti')) {
            Schema::table('guru_tidak_hadir', fn (Blueprint $table) => $table->dropUnique('tidak_hadir_unik_pengganti'));
        }
    }
};