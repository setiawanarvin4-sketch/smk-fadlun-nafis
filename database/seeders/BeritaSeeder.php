<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use App\Support\PlaceholderImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $data = [
            ['judul' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027', 'kategori' => 'Pengumuman'],
            ['judul' => 'Kegiatan Praktik Kerja Lapangan Siswa APHP', 'kategori' => 'Kegiatan'],
            ['judul' => 'Prestasi Siswa dalam Lomba Kompetensi Siswa Tingkat Kabupaten', 'kategori' => 'Prestasi'],
            ['judul' => 'Kunjungan Industri ke Perusahaan Farmasi', 'kategori' => 'Kegiatan'],
            ['judul' => 'Pelaksanaan Ujian Tengah Semester Ganjil', 'kategori' => 'Pengumuman'],
        ];

        foreach ($data as $row) {
            Berita::updateOrCreate(
                ['slug' => Str::slug($row['judul']).'-'.Str::random(5)],
                [
                    'judul' => $row['judul'],
                    'thumbnail' => PlaceholderImage::make('berita', $row['kategori']),
                    'isi' => '<p>Ini adalah konten dummy untuk berita "'.$row['judul'].'". Konten ini dapat diedit langsung melalui Admin.</p>',
                    'ringkasan' => 'Ringkasan singkat mengenai '.$row['judul'].'.',
                    'kategori' => $row['kategori'],
                    'user_id' => $admin->id,
                    'tanggal_publikasi' => now()->subDays(rand(1, 20)),
                    'status' => 'published',
                ]
            );
        }
    }
}