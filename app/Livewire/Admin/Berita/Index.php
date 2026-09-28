<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Berita;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterStatus = '';

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $judul = '';
    public string $isi = '';
    public string $ringkasan = '';
    public string $kategori = 'Umum';
    public string $status = 'draft';
    public $thumbnail = null;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'judul', 'isi', 'ringkasan', 'thumbnail']);
        $this->kategori = 'Umum';
        $this->status = 'draft';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $b = Berita::findOrFail($id);
        $this->editId = $b->id;
        $this->judul = $b->judul;
        $this->isi = $b->isi;
        $this->ringkasan = $b->ringkasan ?? '';
        $this->kategori = $b->kategori;
        $this->status = $b->status;
        $this->thumbnail = null;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-konten'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'ringkasan' => 'nullable|string|max:500',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul).'-'.Str::random(5),
            'isi' => \Mews\Purifier\Facades\Purifier::clean($this->isi),
            'ringkasan' => $this->ringkasan,
            'kategori' => $this->kategori,
            'status' => $this->status,
            'user_id' => auth()->id(),
            'tanggal_publikasi' => $this->status === 'published' ? now() : null,
        ];

        if ($this->thumbnail) {
            if ($this->editId) {
                $old = Berita::find($this->editId)?->thumbnail;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['thumbnail'] = \App\Support\ImageUploader::simpan($this->thumbnail, 'berita', 1200);
        }

        if ($this->editId) {
            unset($data['slug']);
            unset($data['user_id']); // penulis asli tidak berubah walau diedit orang lain
            Berita::findOrFail($this->editId)->update($data);
        } else {
            $b = Berita::create($data);
            ActivityLog::catat('Menambah Berita', 'Berita', $b->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Berita berhasil disimpan.');
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
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-konten'), 403, 'Kepala Sekolah tidak punya akses menghapus data.');

        Berita::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Berita', 'Berita', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Berita berhasil dihapus.');
    }

    public function render()
    {
        $query = Berita::when($this->search, fn ($q) => $q->where('judul', 'like', '%'.$this->search.'%'))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->orderByDesc('created_at');

        return view('livewire.admin.berita.index', [
            'items' => $query->paginate(10),
        ]);
    }
}