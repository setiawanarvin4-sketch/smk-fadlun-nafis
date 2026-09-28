<?php

namespace App\Livewire\Public\Siswa;

use App\Models\Siswa;
use Livewire\Component;

class Show extends Component
{
    public Siswa $siswa;

    public function mount(int $id)
    {
        $this->siswa = Siswa::where('aktif', true)
            ->whereHas('prestasi')
            ->with(['kelas', 'kompetensi', 'prestasi' => fn ($q) => $q->orderByDesc('tahun'), 'ekstraWajib', 'ekstraPilihan'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.siswa.show');
    }
}