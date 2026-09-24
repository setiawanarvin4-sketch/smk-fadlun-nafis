<?php

namespace App\Livewire\Admin\MenuNavigasi;

use App\Models\ActivityLog;
use App\Models\MenuNavigasi;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Index extends Component
{
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public ?int $parent_id = null;
    public string $label = '';
    public string $url = '#';
    public int $urutan = 0;
    public bool $aktif = true;
    public bool $showModal = false;

    public function create(?int $parentId = null)
    {
        $this->reset(['editId', 'label', 'url', 'urutan']);
        $this->parent_id = $parentId;
        $this->url = $parentId ? '' : '#';
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $m = MenuNavigasi::findOrFail($id);
        $this->editId = $m->id;
        $this->parent_id = $m->parent_id;
        $this->label = $m->label;
        $this->url = $m->url;
        $this->urutan = $m->urutan;
        $this->aktif = $m->aktif;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'urutan' => 'integer|min:0',
        ]);

        $data = [
            'parent_id' => $this->parent_id,
            'label' => $this->label,
            'url' => $this->url,
            'urutan' => $this->urutan,
            'aktif' => $this->aktif,
        ];

        if ($this->editId) {
            MenuNavigasi::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Menu Navigasi', 'MenuNavigasi', $this->editId);
        } else {
            $m = MenuNavigasi::create($data);
            ActivityLog::catat('Menambah Menu Navigasi', 'MenuNavigasi', $m->id);
        }

        Cache::forget('menu-navigasi-utama');
        $this->showModal = false;
        session()->flash('success', 'Menu berhasil disimpan.');
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

        MenuNavigasi::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Menu Navigasi', 'MenuNavigasi', $id);
        Cache::forget('menu-navigasi-utama');
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Menu berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.menu-navigasi.index', [
            'items' => MenuNavigasi::whereNull('parent_id')
                ->with(['children' => fn ($q) => $q->orderBy('urutan')])
                ->orderBy('urutan')
                ->get(),
        ]);
    }
}