<?php

namespace App\Livewire\Admin\Agenda;

use App\Models\Agenda;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $judul = '';
    public string $tanggal = '';
    public string $jam = '';
    public string $lokasi = '';
    public string $deskripsi = '';
    public $foto = null;
    public ?string $existingFoto = null;
    public bool $showModal = false;

    public function updatingSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['editId', 'judul', 'jam', 'lokasi', 'deskripsi', 'foto', 'existingFoto']);
        $this->tanggal = now()->toDateString();
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $a = Agenda::findOrFail($id);
        $this->editId = $a->id;
        $this->judul = $a->judul;
        $this->tanggal = $a->tanggal->toDateString();
        $this->jam = $a->jam ? substr($a->jam, 0, 5) : '';
        $this->lokasi = $a->lokasi ?? '';
        $this->deskripsi = $a->deskripsi ?? '';
        $this->foto = null;
        $this->existingFoto = $a->foto;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'tanggal' => $this->tanggal,
            'jam' => $this->jam ?: null,
            'lokasi' => $this->lokasi,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->foto) {
            if ($this->editId) {
                $old = Agenda::find($this->editId)?->foto;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['foto'] = $this->foto->store('agenda', 'public');
        }

        if ($this->editId) {
            Agenda::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Agenda', 'Agenda', $this->editId);
        } else {
            $a = Agenda::create($data);
            ActivityLog::catat('Menambah Agenda', 'Agenda', $a->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Agenda berhasil disimpan.');
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

        $a = Agenda::findOrFail($id);
        if ($a->foto) {
            Storage::disk('public')->delete($a->foto);
        }
        $a->delete();
        ActivityLog::catat('Menghapus Agenda', 'Agenda', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Agenda berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.agenda.index', [
            'items' => Agenda::where('judul', 'like', '%'.$this->search.'%')->orderByDesc('tanggal')->paginate(10),
        ]);
    }
}