<?php

namespace App\Livewire\Public\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kompetensi;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterKelas = '';
    public string $filterKompetensi = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterKelas() { $this->resetPage(); }
    public function updatingFilterKompetensi() { $this->resetPage(); }

    public function render()
    {
        // Cuma tampilkan siswa yang punya minimal 1 prestasi, bukan seluruh
        // data siswa. Kolom sensitif (NISN, no_wa_wali) sudah $hidden di
        // model Siswa sebagai lapis pengaman tambahan.
        $query = Siswa::where('aktif', true)
            ->whereHas('prestasi')
            ->with(['prestasi' => fn ($q) => $q->orderByDesc('tahun')])
            ->when($this->search, fn ($q) => $q->where('nama', 'like', '%'.$this->search.'%'))
            ->when($this->filterKelas, fn ($q) => $q->where('kelas_id', $this->filterKelas))
            ->when($this->filterKompetensi, fn ($q) => $q->where('kompetensi_id', $this->filterKompetensi))
            ->orderBy('nama');

        return view('livewire.public.siswa.index', [
            'items' => $query->paginate(20),
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
            'kompetensiList' => Kompetensi::where('aktif', true)->get(),
        ]);
    }
}