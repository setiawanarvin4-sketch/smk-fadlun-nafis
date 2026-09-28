<?php

namespace App\Livewire\Admin\LoginLog;

use App\Models\ActivityLog;
use App\Models\BlockedIp;
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

    public function bukaBlokir(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403);

        $blokir = BlockedIp::findOrFail($id);
        $blokir->update(['dibuka_pada' => now(), 'dibuka_oleh' => auth()->id()]);

        ActivityLog::catat('Membuka Blokir IP', 'LoginLog', null);
        session()->flash('success', "Blokir untuk IP {$blokir->ip_address} sudah dibuka.");
    }

    public function render()
    {
        $logs = LoginLog::with('user')
            ->when($this->search, fn ($q) => $q->where('email', 'like', '%'.$this->search.'%'))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->orderByDesc('waktu')
            ->paginate(15);

        $ipDiblokir = BlockedIp::whereNull('dibuka_pada')->orderByDesc('diblokir_pada')->get();

        return view('livewire.admin.login-log.index', [
            'logs' => $logs,
            'totalBerhasil' => LoginLog::where('status', 'Berhasil')->where('waktu', '>=', now()->subDays(30))->count(),
            'totalGagal' => LoginLog::where('status', 'Gagal')->where('waktu', '>=', now()->subDays(30))->count(),
            'ipDiblokir' => $ipDiblokir,
            'ipDiblokirList' => $ipDiblokir->pluck('ip_address')->toArray(),
        ]);
    }
}