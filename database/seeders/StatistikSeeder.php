<?php

namespace Database\Seeders;

use App\Models\StatistikSekolah;
use Illuminate\Database\Seeder;

class StatistikSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['label' => 'Guru & Staff', 'nilai' => '54+', 'urutan' => 1],
            ['label' => 'Siswa Aktif', 'nilai' => '1.240+', 'urutan' => 2],
            ['label' => 'Kompetensi Keahlian', 'nilai' => '2', 'urutan' => 3],
            ['label' => 'Prestasi', 'nilai' => '85+', 'urutan' => 4],
            ['label' => 'Alumni', 'nilai' => '2.400+', 'urutan' => 5],
        ];

        foreach ($data as $row) {
            StatistikSekolah::updateOrCreate(['label' => $row['label']], $row + ['aktif' => true]);
        }
    }
}