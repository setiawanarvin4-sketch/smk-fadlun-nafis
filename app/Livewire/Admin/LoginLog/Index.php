<?php

namespace App\Livewire\Admin\LoginLog;

use App\Models\LoginLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function render()
    {
        $logs = LoginLog::with('user')
            ->when($this->search, fn ($q) => $q->where('email', 'like', '%'.$this->search.'%'))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->orderByDesc('waktu')
            ->paginate(15);

        return view('livewire.admin.login-log.index', [
            'logs' => $logs,
            'totalBerhasil' => LoginLog::where('status', 'Berhasil')->count(),
            'totalGagal' => LoginLog::where('status', 'Gagal')->count(),
        ]);
    }
}