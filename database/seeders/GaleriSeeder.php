<?php

namespace Database\Seeders;

use App\Models\Galeri;
use App\Support\PlaceholderImage;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['judul' => 'Upacara Bendera', 'kategori' => 'Kegiatan Sekolah'],
            ['judul' => 'Praktik Laboratorium Farmasi', 'kategori' => 'Farmasi'],
            ['judul' => 'Praktik Pengolahan Hasil Pertanian', 'kategori' => 'PPLG'],
            ['judul' => 'Kegiatan Pembelajaran di Kelas', 'kategori' => 'Pembelajaran'],
            ['judul' => 'Perayaan Hari Kemerdekaan', 'kategori' => 'Event'],
            ['judul' => 'Penyerahan Penghargaan Siswa Berprestasi', 'kategori' => 'Prestasi'],
        ];

        foreach ($data as $i => $row) {
            Galeri::create([
                'judul' => $row['judul'],
                'deskripsi' => 'Dokumentasi kegiatan '.$row['judul'],
                'file' => PlaceholderImage::make('galeri', $row['judul']),
                'kategori' => $row['kategori'],
                'aktif' => true,
                'urutan' => $i + 1,
            ]);
        }
    }
}