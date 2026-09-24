<?php

namespace App\Livewire\Admin\Dokumen;

use App\Models\Dokumen;
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
    public string $kategori = '';
    public string $deskripsi = '';
    public $file = null;
    public bool $status_publik = true;
    public bool $showModal = false;

    public function updatingSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['editId', 'nama', 'kategori', 'deskripsi', 'file']);
        $this->status_publik = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $d = Dokumen::findOrFail($id);
        $this->editId = $d->id;
        $this->nama = $d->nama;
        $this->kategori = $d->kategori ?? '';
        $this->deskripsi = $d->deskripsi ?? '';
        $this->status_publik = $d->status_publik;
        $this->file = null;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'nama' => 'required|string|max:255',
            'file' => $this->editId ? 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120' : 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $data = [
            'nama' => $this->nama,
            'kategori' => $this->kategori,
            'deskripsi' => $this->deskripsi,
            'status_publik' => $this->status_publik,
            'tanggal' => now()->toDateString(),
        ];

        if ($this->file) {
            if ($this->editId) {
                $old = Dokumen::find($this->editId)?->file;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['file'] = $this->file->store('dokumen', 'public');
        }

        if ($this->editId) {
            Dokumen::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Dokumen', 'Dokumen', $this->editId);
        } else {
            $d = Dokumen::create($data);
            ActivityLog::catat('Menambah Dokumen', 'Dokumen', $d->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Dokumen berhasil disimpan.');
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

        $d = Dokumen::findOrFail($id);
        if ($d->file) {
            Storage::disk('public')->delete($d->file);
        }
        $d->delete();
        ActivityLog::catat('Menghapus Dokumen', 'Dokumen', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Dokumen berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.dokumen.index', [
            'items' => Dokumen::where('nama', 'like', '%'.$this->search.'%')->orderByDesc('id')->paginate(10),
        ]);
    }
}