<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kompetensi;
use App\Support\PlaceholderImage;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $siswaList = Siswa::inRandomOrder()->limit(4)->get();
        $aphp = Kompetensi::where('nama', 'like', '%Agribisnis%')->first();

        $data = [
            ['judul' => 'Juara 1 Lomba Kompetensi Siswa Tingkat Kabupaten', 'kategori' => 'Akademik', 'tingkat' => 'Kabupaten', 'tahun' => 2025],
            ['judul' => 'Juara 2 Lomba Cerdas Cermat Tingkat Provinsi', 'kategori' => 'Akademik', 'tingkat' => 'Provinsi', 'tahun' => 2025],
            ['judul' => 'Juara 1 Turnamen Futsal Antar SMK', 'kategori' => 'Non-Akademik', 'tingkat' => 'Kabupaten', 'tahun' => 2026],
            ['judul' => 'Juara 3 Lomba Karya Tulis Ilmiah', 'kategori' => 'Akademik', 'tingkat' => 'Kabupaten', 'tahun' => 2026],
        ];

        foreach ($data as $i => $row) {
            Prestasi::create([
                'judul' => $row['judul'],
                'kategori' => $row['kategori'],
                'tingkat' => $row['tingkat'],
                'tahun' => $row['tahun'],
                'siswa_id' => $siswaList[$i]->id ?? null,
                'kompetensi_id' => $aphp->id,
                'foto' => PlaceholderImage::make('prestasi', $row['judul']),
                'deskripsi' => 'Prestasi yang diraih siswa SMK Fadlun Nafis Bangsri.',
            ]);
        }
    }
}