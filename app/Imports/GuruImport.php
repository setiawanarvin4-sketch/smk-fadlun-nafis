<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    public int $berhasil = 0;
    public array $gagal = [];

    public function collection($rows)
    {
        foreach ($rows as $i => $row) {
            $baris = $i + 2;

            $nama = trim((string) ($row['nama'] ?? ''));
            $nip = trim((string) ($row['nip'] ?? ''));
            $email = trim((string) ($row['email'] ?? ''));

            if (! $nama || ! $nip || ! $email) {
                $this->gagal[] = "Baris {$baris}: nama/NIP/email ada yang kosong, dilewati.";
                continue;
            }

            if (Guru::where('nip', $nip)->exists()) {
                $this->gagal[] = "Baris {$baris}: NIP {$nip} ({$nama}) sudah terdaftar, dilewati.";
                continue;
            }

            if (User::where('email', $email)->exists()) {
                $this->gagal[] = "Baris {$baris}: email {$email} ({$nama}) sudah dipakai akun lain, dilewati.";
                continue;
            }

            try {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => 'Guru@'.$nip,
                    'role' => 'guru',
                    'email_verified_at' => now(),
                ]);

                $guruBaru = Guru::create([
                    'user_id' => $user->id,
                    'nama' => $nama,
                    'nip' => $nip,
                    'jabatan' => trim((string) ($row['jabatan'] ?? '')) ?: null,
                    'bidang' => trim((string) ($row['bidang'] ?? '')) ?: null,
                    'no_wa' => trim((string) ($row['no_wa'] ?? '')) ?: null,
                    'aktif' => true,
                ]);

                $mapelIds = [];
                $mapelTidakDitemukan = [];
                foreach (explode(',', (string) ($row['mata_pelajaran'] ?? '')) as $namaMapel) {
                    $namaMapel = trim($namaMapel);
                    if (! $namaMapel) continue;

                    $mapel = MataPelajaran::whereRaw('LOWER(nama) = ?', [strtolower($namaMapel)])->first();
                    if ($mapel) {
                        $mapelIds[] = $mapel->id;
                    } else {
                        $mapelTidakDitemukan[] = $namaMapel;
                    }
                }

                if ($mapelIds) {
                    $guruBaru->mataPelajaran()->sync($mapelIds);
                }

                if ($mapelTidakDitemukan) {
                    $this->gagal[] = "Baris {$baris}: guru {$nama} berhasil disimpan, tapi mapel '".implode("', '", $mapelTidakDitemukan)."' tidak ditemukan (cek ejaan di menu Mata Pelajaran).";
                }

                $this->berhasil++;
            } catch (\Throwable $e) {
                $this->gagal[] = "Baris {$baris}: gagal disimpan ({$nama}).";
            }
        }
    }
}