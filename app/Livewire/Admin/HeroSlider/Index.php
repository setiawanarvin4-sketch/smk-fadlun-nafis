<?php

namespace App\Livewire\Admin\HeroSlider;

use App\Models\HeroSlider;
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
    public string $badge = '';
    public string $button1_text = '';
    public string $button1_url = '';
    public string $button2_text = '';
    public string $button2_url = '';
    public int $urutan = 0;
    public bool $aktif = true;
    public $foto = null;
    public ?string $existingFoto = null;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'judul', 'deskripsi', 'badge', 'button1_text', 'button1_url', 'button2_text', 'button2_url', 'foto']);
        $this->urutan = HeroSlider::max('urutan') + 1;
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $h = HeroSlider::findOrFail($id);
        $this->editId = $h->id;
        $this->judul = $h->judul;
        $this->deskripsi = $h->deskripsi ?? '';
        $this->badge = $h->badge ?? '';
        $this->button1_text = $h->button1_text ?? '';
        $this->button1_url = $h->button1_url ?? '';
        $this->button2_text = $h->button2_text ?? '';
        $this->button2_url = $h->button2_url ?? '';
        $this->urutan = $h->urutan;
        $this->aktif = $h->aktif;
        $this->foto = null;
        $this->existingFoto = $h->foto;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-konten'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'foto' => $this->editId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'badge' => $this->badge,
            'button1_text' => $this->button1_text,
            'button1_url' => $this->button1_url,
            'button2_text' => $this->button2_text,
            'button2_url' => $this->button2_url,
            'urutan' => $this->urutan,
            'aktif' => $this->aktif,
        ];

        if ($this->foto) {
            if ($this->editId) {
                $old = HeroSlider::find($this->editId)?->foto;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['foto'] = \App\Support\ImageUploader::simpan($this->foto, 'hero', 1200);
        }

        if ($this->editId) {
            HeroSlider::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Hero Slider', 'HeroSlider', $this->editId);
        } else {
            $h = HeroSlider::create($data);
            ActivityLog::catat('Menambah Hero Slider', 'HeroSlider', $h->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Hero slider berhasil disimpan.');
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

        $h = HeroSlider::findOrFail($id);
        if ($h->foto) {
            Storage::disk('public')->delete($h->foto);
        }
        $h->delete();
        ActivityLog::catat('Menghapus Hero Slider', 'HeroSlider', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Hero slider berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.hero-slider.index', [
            'items' => HeroSlider::orderBy('urutan')->paginate(10),
        ]);
    }
}