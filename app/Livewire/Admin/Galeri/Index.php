<?php

namespace App\Livewire\Admin\Galeri;

use App\Models\Galeri;
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
    public string $deskripsi = '';
    public string $kategori = 'Kegiatan Sekolah';
    public $file = null;
    public bool $aktif = true;
    public bool $showModal = false;

    public function updatingSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['editId', 'judul', 'deskripsi', 'file']);
        $this->kategori = 'Kegiatan Sekolah';
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $g = Galeri::findOrFail($id);
        $this->editId = $g->id;
        $this->judul = $g->judul;
        $this->deskripsi = $g->deskripsi ?? '';
        $this->kategori = $g->kategori;
        $this->aktif = $g->aktif;
        $this->file = null;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Kegiatan Sekolah,Pembelajaran,APHP,Farmasi,Prestasi,Event',
            'file' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->kategori,
            'aktif' => $this->aktif,
        ];

        if ($this->file) {
            if ($this->editId) {
                $old = Galeri::find($this->editId)?->file;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['file'] = $this->file->store('galeri', 'public');
        }

        if ($this->editId) {
            Galeri::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Galeri', 'Galeri', $this->editId);
        } else {
            $g = Galeri::create($data + ['urutan' => Galeri::max('urutan') + 1]);
            ActivityLog::catat('Menambah Galeri', 'Galeri', $g->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Galeri berhasil disimpan.');
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

        $g = Galeri::findOrFail($id);
        if ($g->file) {
            Storage::disk('public')->delete($g->file);
        }
        $g->delete();
        ActivityLog::catat('Menghapus Galeri', 'Galeri', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Galeri berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.galeri.index', [
            'items' => Galeri::where('judul', 'like', '%'.$this->search.'%')->orderByDesc('id')->paginate(12),
        ]);
    }
}