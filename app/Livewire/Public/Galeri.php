<?php

namespace App\Livewire\Public;

use App\Models\Galeri as GaleriModel;
use Livewire\Component;
use Livewire\WithPagination;

class Galeri extends Component
{
    use WithPagination;

    public string $filterKategori = '';

    public function render()
    {
        return view('livewire.public.galeri', [
            'items' => GaleriModel::where('aktif', true)
                ->when($this->filterKategori, fn ($q) => $q->where('kategori', $this->filterKategori))
                ->orderByDesc('id')
                ->paginate(12),
        ]);
    }
}