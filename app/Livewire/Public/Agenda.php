<?php

namespace App\Livewire\Public;

use App\Models\Agenda as AgendaModel;
use Livewire\Component;
use Livewire\WithPagination;

class Agenda extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.public.agenda', [
            'items' => AgendaModel::orderBy('tanggal')->paginate(10),
        ]);
    }
}