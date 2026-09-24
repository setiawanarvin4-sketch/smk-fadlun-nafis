<?php

namespace App\Livewire\Public\Berita;

use App\Models\Berita;
use Livewire\Component;

class Show extends Component
{
    public Berita $berita;

    public function mount(string $slug)
    {
        $this->berita = Berita::published()->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.berita.show', [
            'terkait' => Berita::published()->where('id', '!=', $this->berita->id)->limit(3)->get(),
        ]);
    }
}