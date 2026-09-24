<?php

namespace App\Livewire\Guru;

use App\Models\JadwalPelajaran;
use App\Models\Guru;
use Livewire\Component;

class Jadwal extends Component
{
    public function render()
    {
        $guru = Guru::where('user_id', auth()->id())->firstOrFail();
        $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $jadwalPerHari = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('aktif', true)
            ->get()
            ->groupBy('hari')
            ->map(fn ($group) => $group->sortBy('jam_mulai'));

        return view('livewire.guru.jadwal', [
            'hariUrutan' => $hariUrutan,
            'jadwalPerHari' => $jadwalPerHari,
            'totalJam' => $jadwalPerHari->flatten()->count(),
        ]);
    }
}