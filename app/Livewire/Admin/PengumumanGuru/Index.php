<?php

namespace App\Livewire\Admin\PengumumanGuru;

use App\Models\PengumumanGuru;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $judul = '';
    public string $isi = '';
    public bool $aktif = true;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'judul', 'isi']);
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $p = PengumumanGuru::findOrFail($id);
        $this->editId = $p->id;
        $this->judul = $p->judul;
        $this->isi = $p->isi;
        $this->aktif = $p->aktif;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $data = ['judul' => $this->judul, 'isi' => $this->isi, 'aktif' => $this->aktif];

        if ($this->editId) {
            PengumumanGuru::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Pengumuman Guru', 'PengumumanGuru', $this->editId);
        } else {
            $p = PengumumanGuru::create($data);
            ActivityLog::catat('Menambah Pengumuman Guru', 'PengumumanGuru', $p->id);
        }

        $this->dispatch('notify', message: 'Pengumuman berhasil disimpan.', type: 'success');
        $this->showModal = false;
        session()->flash('success', 'Pengumuman berhasil disimpan.');
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

        PengumumanGuru::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Pengumuman Guru', 'PengumumanGuru', $id);
        $this->dispatch('notify', message: 'Pengumuman berhasil dihapus.', type: 'success');
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Pengumuman berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.pengumuman-guru.index', [
            'items' => PengumumanGuru::latest()->paginate(10),
        ]);
    }
}