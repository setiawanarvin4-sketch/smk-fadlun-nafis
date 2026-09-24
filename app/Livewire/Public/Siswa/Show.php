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
            ->with(['kelas', 'kompetensi', 'prestasi', 'ekstraWajib', 'ekstraPilihan'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.siswa.show');
    }
}