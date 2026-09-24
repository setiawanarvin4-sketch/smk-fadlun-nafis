<?php

namespace App\Livewire\Public\Berita;

use App\Models\Berita;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        return view('livewire.public.berita.index', [
            'items' => Berita::published()
                ->when($this->search, fn ($q) => $q->where('judul', 'like', '%'.$this->search.'%'))
                ->orderByDesc('tanggal_publikasi')
                ->paginate(9),
        ]);
    }
}