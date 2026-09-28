<?php

namespace App\Livewire\Admin\Pengumuman;

use App\Models\Pengumuman;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $judul = '';
    public string $deskripsi = '';
    public string $label_atas = 'Selamat Datang';
    public string $button_text = '';
    public string $button_url = '';
    public bool $aktif = true;
    public $gambar = null;
    public ?string $existingGambar = null;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'judul', 'deskripsi', 'button_text', 'button_url', 'gambar', 'existingGambar']);
        $this->label_atas = 'Selamat Datang';
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $p = Pengumuman::findOrFail($id);
        $this->editId = $p->id;
        $this->judul = $p->judul;
        $this->deskripsi = $p->deskripsi ?? '';
        $this->label_atas = $p->label_atas ?? 'Selamat Datang';
        $this->button_text = $p->button_text ?? '';
        $this->button_url = $p->button_url ?? '';
        $this->aktif = $p->aktif;
        $this->gambar = null;
        $this->existingGambar = $p->gambar;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'label_atas' => $this->label_atas,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'aktif' => $this->aktif,
        ];

        $existing = $this->editId ? Pengumuman::find($this->editId) : null;

        if ($this->gambar) {
            if ($existing?->gambar) {
                Storage::disk('public')->delete($existing->gambar);
            }
            $data['gambar'] = \App\Support\ImageUploader::simpan($this->gambar, 'pengumuman', 1200);
        }

        if ($this->aktif) {
            Pengumuman::where('id', '!=', $this->editId)->update(['aktif' => false]);
        }

        if ($this->editId) {
            Pengumuman::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Pengumuman', 'Pengumuman', $this->editId);
        } else {
            $p = Pengumuman::create($data);
            ActivityLog::catat('Menambah Pengumuman', 'Pengumuman', $p->id);
        }

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

        $p = Pengumuman::findOrFail($id);
        if ($p->gambar) {
            Storage::disk('public')->delete($p->gambar);
        }
        $p->delete();
        ActivityLog::catat('Menghapus Pengumuman', 'Pengumuman', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Pengumuman berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.pengumuman.index', [
            'items' => Pengumuman::latest()->paginate(10),
        ]);
    }
}