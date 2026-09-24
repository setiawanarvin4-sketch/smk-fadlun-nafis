<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['judul' => 'Rapat Orang Tua Siswa', 'tanggal' => now()->addDays(5), 'jam' => '08:00', 'lokasi' => 'Aula Sekolah'],
            ['judul' => 'Ujian Tengah Semester', 'tanggal' => now()->addDays(10), 'jam' => '07:30', 'lokasi' => 'Ruang Kelas'],
            ['judul' => 'Praktik Kerja Lapangan Dimulai', 'tanggal' => now()->addDays(15), 'jam' => null, 'lokasi' => 'Industri Mitra'],
            ['judul' => 'Peringatan Hari Pendidikan Nasional', 'tanggal' => now()->addDays(20), 'jam' => '08:00', 'lokasi' => 'Lapangan Sekolah'],
            ['judul' => 'Rapat Evaluasi Semester', 'tanggal' => now()->addDays(30), 'jam' => '13:00', 'lokasi' => 'Ruang Guru'],
        ];

        foreach ($data as $row) {
            Agenda::create($row);
        }
    }
}