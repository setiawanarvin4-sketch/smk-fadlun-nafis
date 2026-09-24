<?php

namespace App\Livewire\Admin\Ekstrakurikuler;

use App\Models\Ekstrakurikuler;
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
    public string $nama = '';
    public string $deskripsi = '';
    public string $visi = '';
    public string $misi = '';
    public string $pembina = '';
    public $foto = null;
    public $foto_kegiatan_1 = null;
    public $foto_kegiatan_2 = null;
    public $foto_kegiatan_3 = null;
    public ?string $existingFotoKegiatan1 = null;
    public ?string $existingFotoKegiatan2 = null;
    public ?string $existingFotoKegiatan3 = null;
    public bool $aktif = true;
    public bool $showModal = false;

    public function updatingSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset([
            'editId', 'nama', 'deskripsi', 'visi', 'misi', 'pembina', 'foto',
            'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3',
            'existingFotoKegiatan1', 'existingFotoKegiatan2', 'existingFotoKegiatan3',
        ]);
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $e = Ekstrakurikuler::findOrFail($id);
        $this->editId = $e->id;
        $this->nama = $e->nama;
        $this->deskripsi = $e->deskripsi ?? '';
        $this->visi = $e->visi ?? '';
        $this->misi = $e->misi ?? '';
        $this->pembina = $e->pembina ?? '';
        $this->aktif = $e->aktif;
        $this->foto = null;
        $this->foto_kegiatan_1 = null;
        $this->foto_kegiatan_2 = null;
        $this->foto_kegiatan_3 = null;
        $this->existingFotoKegiatan1 = $e->foto_kegiatan_1;
        $this->existingFotoKegiatan2 = $e->foto_kegiatan_2;
        $this->existingFotoKegiatan3 = $e->foto_kegiatan_3;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|max:5120',
            'foto_kegiatan_1' => 'nullable|image|max:5120',
            'foto_kegiatan_2' => 'nullable|image|max:5120',
            'foto_kegiatan_3' => 'nullable|image|max:5120',
        ]);

        $data = [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'visi' => $this->visi,
            'misi' => $this->misi,
            'pembina' => $this->pembina,
            'aktif' => $this->aktif,
        ];

        $existing = $this->editId ? Ekstrakurikuler::find($this->editId) : null;

        if ($this->foto) {
            if ($existing?->foto) {
                Storage::disk('public')->delete($existing->foto);
            }
            $data['foto'] = $this->foto->store('ekstrakurikuler', 'public');
        }

        foreach (['foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3'] as $field) {
            if ($this->$field) {
                if ($existing?->$field) {
                    Storage::disk('public')->delete($existing->$field);
                }
                $data[$field] = $this->$field->store('ekstrakurikuler/kegiatan', 'public');
            }
        }

        if ($this->editId) {
            Ekstrakurikuler::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Ekstrakurikuler', 'Ekstrakurikuler', $this->editId);
        } else {
            $e = Ekstrakurikuler::create($data);
            ActivityLog::catat('Menambah Ekstrakurikuler', 'Ekstrakurikuler', $e->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Ekstrakurikuler berhasil disimpan.');
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

        $e = Ekstrakurikuler::findOrFail($id);
        foreach (['foto', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3'] as $field) {
            if ($e->$field) {
                Storage::disk('public')->delete($e->$field);
            }
        }
        $e->delete();
        ActivityLog::catat('Menghapus Ekstrakurikuler', 'Ekstrakurikuler', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.ekstrakurikuler.index', [
            'items' => Ekstrakurikuler::where('nama', 'like', '%'.$this->search.'%')->orderBy('nama')->paginate(10),
        ]);
    }
}