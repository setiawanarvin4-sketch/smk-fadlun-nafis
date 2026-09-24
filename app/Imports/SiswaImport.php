<?php

namespace App\Imports;

use App\Models\Ekstrakurikuler;
use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;
    public array $gagal = [];

    public function collection($rows)
    {
        foreach ($rows as $i => $row) {
            $baris = $i + 2;

            $nama = trim((string) ($row['nama'] ?? ''));
            $namaKelas = trim((string) ($row['nama_kelas'] ?? ''));

            if (! $nama) {
                $this->gagal[] = "Baris {$baris}: nama kosong, dilewati.";
                continue;
            }

            $kelas = Kelas::where('nama_kelas', $namaKelas)->first();
            if (! $kelas) {
                $this->gagal[] = "Baris {$baris}: kelas '{$namaKelas}' tidak ditemukan, dilewati.";
                continue;
            }

            $nis = trim((string) ($row['nis'] ?? '')) ?: null;
            $nisn = trim((string) ($row['nisn'] ?? '')) ?: null;

            if ($nis && Siswa::where('nis', $nis)->exists()) {
                $this->gagal[] = "Baris {$baris}: NIS {$nis} ({$nama}) sudah terdaftar, dilewati.";
                continue;
            }
            if ($nisn && Siswa::where('nisn', $nisn)->exists()) {
                $this->gagal[] = "Baris {$baris}: NISN {$nisn} ({$nama}) sudah terdaftar, dilewati.";
                continue;
            }

            $jk = strtoupper(trim((string) ($row['jenis_kelamin_l_p'] ?? $row['jenis_kelamin'] ?? '')));
            $jk = in_array($jk, ['L', 'P']) ? $jk : null;

            try {
                $siswaBaru = Siswa::create([
                    'nama' => $nama,
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'kelas_id' => $kelas->id,
                    'kompetensi_id' => $kelas->kompetensi_id,
                    'jenis_kelamin' => $jk,
                    'aktif' => true,
                ]);

                $syncData = [];
                $ekstraTidakDitemukan = [];

                foreach (explode(',', (string) ($row['ekstra_wajib'] ?? '')) as $namaEkstra) {
                    $namaEkstra = trim($namaEkstra);
                    if (! $namaEkstra) continue;

                    $ekstra = Ekstrakurikuler::whereRaw('LOWER(nama) = ?', [strtolower($namaEkstra)])->first();
                    if ($ekstra) {
                        $syncData[$ekstra->id] = ['jenis' => 'Wajib'];
                    } else {
                        $ekstraTidakDitemukan[] = $namaEkstra;
                    }
                }

                foreach (explode(',', (string) ($row['ekstra_pilihan'] ?? '')) as $namaEkstra) {
                    $namaEkstra = trim($namaEkstra);
                    if (! $namaEkstra) continue;

                    $ekstra = Ekstrakurikuler::whereRaw('LOWER(nama) = ?', [strtolower($namaEkstra)])->first();
                    if ($ekstra) {
                        $syncData[$ekstra->id] = ['jenis' => 'Pilihan'];
                    } else {
                        $ekstraTidakDitemukan[] = $namaEkstra;
                    }
                }

                if ($syncData) {
                    $siswaBaru->ekstrakurikuler()->sync($syncData);
                }

                if ($ekstraTidakDitemukan) {
                    $this->gagal[] = "Baris {$baris}: siswa {$nama} berhasil disimpan, tapi ekstra '".implode("', '", $ekstraTidakDitemukan)."' tidak ditemukan (cek ejaan di menu Ekstrakurikuler).";
                }

                $this->berhasil++;
            } catch (\Throwable $e) {
                $this->gagal[] = "Baris {$baris}: gagal disimpan ({$nama}).";
            }
        }
    }
}