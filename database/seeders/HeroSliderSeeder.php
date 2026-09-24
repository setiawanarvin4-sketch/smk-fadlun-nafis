<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use Illuminate\Database\Seeder;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        if (HeroSlider::count() > 0) {
            return;
        }

        $slides = [
            [
                'judul' => 'Membentuk Generasi Berakhlak Mulia & Siap Kerja',
                'deskripsi' => 'Belajar, Berkarya, dan Berprestasi bersama SMK Fadlun Nafis Bangsri.',
                'badge' => 'SMK FADLUN NAFIS BANGSRI',
                'foto' => 'hero/hero1.jpg',
                'button1_text' => 'Info PPDB',
                'button1_url' => '/ppdb',
                'button2_text' => 'Profil Sekolah',
                'button2_url' => '/profil',
                'urutan' => 1,
            ],
            [
                'judul' => 'Agribisnis Pengolahan Hasil Pertanian',
                'deskripsi' => 'Kompetensi keahlian yang membekali siswa dengan keterampilan pengolahan hasil pertanian modern.',
                'badge' => 'KOMPETENSI KEAHLIAN',
                'foto' => 'hero/hero2.jpg',
                'button1_text' => 'Lihat Kompetensi',
                'button1_url' => '/akademik',
                'button2_text' => '',
                'button2_url' => '',
                'urutan' => 2,
            ],
            [
                'judul' => 'Farmasi Klinis dan Komunitas',
                'deskripsi' => 'Menyiapkan tenaga kesehatan terampil, berakhlak, dan siap terjun ke dunia kerja.',
                'badge' => 'KOMPETENSI KEAHLIAN',
                'foto' => 'hero/hero3.jpg',
                'button1_text' => 'Lihat Kompetensi',
                'button1_url' => '/akademik',
                'button2_text' => '',
                'button2_url' => '',
                'urutan' => 3,
            ],
        ];

        foreach ($slides as $s) {
            $s['aktif'] = true;
            HeroSlider::create($s);
        }
    }
}