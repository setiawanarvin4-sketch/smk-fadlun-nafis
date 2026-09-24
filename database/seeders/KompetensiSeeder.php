<?php

namespace Database\Seeders;

use App\Models\Kompetensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KompetensiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Agribisnis Pengolahan Hasil Pertanian', 'deskripsi' => 'Kompetensi keahlian yang membekali siswa dengan kemampuan pengolahan hasil pertanian, teknik produksi, dan pengendalian mutu produk pangan.', 'urutan' => 1],
            ['nama' => 'Farmasi Klinis dan Komunitas', 'deskripsi' => 'Kompetensi keahlian yang membekali siswa dengan pengetahuan dan keterampilan dasar di bidang farmasi klinis dan pelayanan kefarmasian di masyarakat.', 'urutan' => 2],
        ];

        foreach ($data as $row) {
            Kompetensi::updateOrCreate(
                ['slug' => Str::slug($row['nama'])],
                array_merge($row, ['aktif' => true])
            );
        }
    }
}