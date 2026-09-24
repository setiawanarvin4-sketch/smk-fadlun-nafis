<?php

namespace Database\Seeders;

use App\Models\MenuNavigasi;
use Illuminate\Database\Seeder;

class MenuNavigasiSeeder extends Seeder
{
    public function run(): void
    {
        if (MenuNavigasi::count() > 0) {
            return;
        }

        $struktur = [
            ['label' => 'Beranda', 'url' => '/'],
            ['label' => 'Profil', 'url' => '#', 'children' => [
                ['label' => 'Profil Sekolah', 'url' => '/profil'],
                ['label' => 'Sejarah', 'url' => '/profil#sejarah'],
                ['label' => 'Visi, Misi & Motto', 'url' => '/profil#visi-misi'],
                ['label' => 'Struktur Organisasi', 'url' => '/profil#struktur'],
                ['label' => 'Guru & Tenaga Kependidikan', 'url' => '/profil#guru'],
            ]],
            ['label' => 'Akademik', 'url' => '#', 'children' => [
                ['label' => 'Kompetensi Keahlian', 'url' => '/akademik'],
                ['label' => 'Kalender Akademik', 'url' => '/agenda'],
            ]],
            ['label' => 'Kesiswaan', 'url' => '#', 'children' => [
                ['label' => 'Data Siswa', 'url' => '/data-siswa'],
                ['label' => 'Ekstrakurikuler', 'url' => '/ekstrakurikuler'],
            ]],
            ['label' => 'Prestasi', 'url' => '/prestasi'],
            ['label' => 'Informasi', 'url' => '#', 'children' => [
                ['label' => 'Pengumuman', 'url' => '/berita'],
                ['label' => 'Agenda', 'url' => '/agenda'],
                ['label' => 'PPDB', 'url' => '/ppdb'],
                ['label' => 'Download Dokumen', 'url' => '/download'],
            ]],
            ['label' => 'Berita', 'url' => '/berita'],
            ['label' => 'Galeri', 'url' => '/galeri'],
            ['label' => 'Keuangan', 'url' => '/keuangan'],
            ['label' => 'Kontak', 'url' => '/kontak'],
        ];

        foreach ($struktur as $i => $menu) {
            $parent = MenuNavigasi::create([
                'label' => $menu['label'],
                'url' => $menu['url'],
                'urutan' => $i,
                'aktif' => true,
            ]);

            foreach ($menu['children'] ?? [] as $j => $child) {
                MenuNavigasi::create([
                    'parent_id' => $parent->id,
                    'label' => $child['label'],
                    'url' => $child['url'],
                    'urutan' => $j,
                    'aktif' => true,
                ]);
            }
        }
    }
}