<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Kompetensi;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $aphp = Kompetensi::where('nama', 'like', '%Agribisnis%')->first();
        $farmasi = Kompetensi::where('nama', 'like', '%Farmasi%')->first();

        $data = [
            ['nama_kelas' => 'X APHP 1', 'kompetensi_id' => $aphp->id, 'tingkat' => 10],
            ['nama_kelas' => 'XI APHP 1', 'kompetensi_id' => $aphp->id, 'tingkat' => 11],
            ['nama_kelas' => 'X FARMASI 1', 'kompetensi_id' => $farmasi->id, 'tingkat' => 10],
            ['nama_kelas' => 'XI FARMASI 1', 'kompetensi_id' => $farmasi->id, 'tingkat' => 11],
        ];

        foreach ($data as $row) {
            Kelas::updateOrCreate(['nama_kelas' => $row['nama_kelas']], $row);
        }
    }
}