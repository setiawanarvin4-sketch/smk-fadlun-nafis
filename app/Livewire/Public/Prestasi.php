<?php

namespace App\Livewire\Public;

use App\Models\Prestasi as PrestasiModel;
use Livewire\Component;
use Livewire\WithPagination;

class Prestasi extends Component
{
    use WithPagination;

    public string $filterKategori = '';

    public function render()
    {
        return view('livewire.public.prestasi', [
            'items' => PrestasiModel::with('siswa')
                ->when($this->filterKategori, fn ($q) => $q->where('kategori', $this->filterKategori))
                ->orderByDesc('tahun')
                ->paginate(9),
        ]);
    }
}