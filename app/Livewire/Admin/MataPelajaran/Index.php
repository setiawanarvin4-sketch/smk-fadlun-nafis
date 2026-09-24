<?php

namespace App\Livewire\Admin\MataPelajaran;

use App\Models\MataPelajaran;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $nama = '';
    public bool $aktif = true;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'nama']);
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $m = MataPelajaran::findOrFail($id);
        $this->editId = $m->id;
        $this->nama = $m->nama;
        $this->aktif = $m->aktif;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate(['nama' => 'required|string|max:255']);

        if ($this->editId) {
            MataPelajaran::findOrFail($this->editId)->update(['nama' => $this->nama, 'aktif' => $this->aktif]);
            ActivityLog::catat('Mengubah Mata Pelajaran', 'MataPelajaran', $this->editId);
        } else {
            $m = MataPelajaran::create(['nama' => $this->nama, 'aktif' => true]);
            ActivityLog::catat('Menambah Mata Pelajaran', 'MataPelajaran', $m->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Mata pelajaran berhasil disimpan.');
    }

    public function konfirmasiHapus(int $id)
    {
        $this->konfirmasiHapusId = $id;
    }

    public function batalHapus()
    {
        $this->konfirmasiHapusId = null;
    }

    public function delete(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses menghapus data.');

        MataPelajaran::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Mata Pelajaran', 'MataPelajaran', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Mata pelajaran berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.mata-pelajaran.index', [
            'items' => MataPelajaran::where('nama', 'like', '%'.$this->search.'%')->orderBy('nama')->paginate(10),
        ]);
    }
}