<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Support\PlaceholderImage;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $mapelList = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Agama', 'IPA', 'PJOK', 'Produktif APHP', 'Produktif Farmasi'];
        foreach ($mapelList as $nama) {
            MataPelajaran::updateOrCreate(['nama' => $nama], ['aktif' => true]);
        }

        $data = [
            ['nama' => 'Siti Rahmawati', 'nip' => '19850312001', 'jabatan' => 'Guru Matematika', 'bidang' => 'Matematika', 'mapel' => ['Matematika']],
            ['nama' => 'Ahmad Fauzi', 'nip' => '19870721002', 'jabatan' => 'Guru Bahasa Indonesia', 'bidang' => 'Bahasa', 'mapel' => ['Bahasa Indonesia']],
            ['nama' => 'Dewi Kurniasari', 'nip' => '19900105003', 'jabatan' => 'Guru Bahasa Inggris', 'bidang' => 'Bahasa', 'mapel' => ['Bahasa Inggris']],
            ['nama' => 'Muhammad Iqbal', 'nip' => '19880908004', 'jabatan' => 'Guru Produktif APHP', 'bidang' => 'APHP', 'mapel' => ['Produktif APHP', 'IPA']],
        ];

        foreach ($data as $row) {
            $email = strtolower(str_replace(' ', '.', $row['nama'])).'@smkfadlunnafis.sch.id';

            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $row['nama'], 'password' => 'Guru123!', 'role' => 'guru', 'email_verified_at' => now()]
            );

            $guru = Guru::updateOrCreate(
                ['nip' => $row['nip']],
                [
                    'user_id' => $user->id,
                    'nama' => $row['nama'],
                    'jabatan' => $row['jabatan'],
                    'bidang' => $row['bidang'],
                    'foto' => PlaceholderImage::make('guru', $row['nama']),
                    'aktif' => true,
                ]
            );

            $mapelIds = MataPelajaran::whereIn('nama', $row['mapel'])->pluck('id');
            $guru->mataPelajaran()->sync($mapelIds);
        }
    }
}