<?php

namespace App\Livewire\Admin\ActivityLog;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $filterModul = '';
    public string $search = '';

    public function updatingFilterModul() { $this->resetPage(); }
    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $query = ActivityLog::with('user')
            ->when($this->filterModul, fn ($q) => $q->where('modul', $this->filterModul))
            ->when($this->search, fn ($q) => $q->where('aktivitas', 'like', '%'.$this->search.'%'))
            ->orderByDesc('created_at');

        $modulList = ActivityLog::select('modul')->distinct()->whereNotNull('modul')->pluck('modul');

        return view('livewire.admin.activity-log.index', [
            'items' => $query->paginate(20),
            'modulList' => $modulList,
        ]);
    }
}