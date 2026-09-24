<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $namaLaki = ['Ahmad Rizki', 'Budi Santoso', 'Candra Wijaya', 'Doni Kurniawan', 'Eko Prasetyo', 'Fajar Nugroho'];
        $namaPerempuan = ['Ayu Lestari', 'Bella Putri', 'Citra Dewi', 'Dinda Anggraini', 'Eka Wulandari', 'Fitri Handayani'];

        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 6; $i++) {
                $isLaki = $i % 2 === 0;
                $namaDepan = $isLaki ? $namaLaki[array_rand($namaLaki)] : $namaPerempuan[array_rand($namaPerempuan)];
                $nama = $namaDepan.' '.$i;
                $nis = $kelas->id.str_pad($i, 3, '0', STR_PAD_LEFT);

                Siswa::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'nama' => $nama,
                        'nisn' => '00'.$nis,
                        'kelas_id' => $kelas->id,
                        'kompetensi_id' => $kelas->kompetensi_id,
                        'jenis_kelamin' => $isLaki ? 'L' : 'P',
                        'aktif' => true,
                    ]
                );
            }
        }
    }
}