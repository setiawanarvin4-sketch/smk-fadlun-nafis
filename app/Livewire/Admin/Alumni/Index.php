<?php

namespace App\Livewire\Admin\Alumni;

use App\Models\Alumni;
use App\Models\Kompetensi;
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
    public string $nama = '';
    public ?int $kompetensi_id = null;
    public string $tahun_lulus = '';
    public string $pekerjaan_sekarang = '';
    public string $testimoni = '';
    public bool $aktif = true;
    public $foto = null;
    public ?string $existingFoto = null;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'nama', 'kompetensi_id', 'tahun_lulus', 'pekerjaan_sekarang', 'testimoni', 'foto', 'existingFoto']);
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $a = Alumni::findOrFail($id);
        $this->editId = $a->id;
        $this->nama = $a->nama;
        $this->kompetensi_id = $a->kompetensi_id;
        $this->tahun_lulus = $a->tahun_lulus ?? '';
        $this->pekerjaan_sekarang = $a->pekerjaan_sekarang ?? '';
        $this->testimoni = $a->testimoni ?? '';
        $this->aktif = $a->aktif;
        $this->foto = null;
        $this->existingFoto = $a->foto;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|max:5120',
        ]);

        $data = [
            'nama' => $this->nama,
            'kompetensi_id' => $this->kompetensi_id ?: null,
            'tahun_lulus' => $this->tahun_lulus,
            'pekerjaan_sekarang' => $this->pekerjaan_sekarang,
            'testimoni' => $this->testimoni,
            'aktif' => $this->aktif,
        ];

        $existing = $this->editId ? Alumni::find($this->editId) : null;

        if ($this->foto) {
            if ($existing?->foto) {
                Storage::disk('public')->delete($existing->foto);
            }
            $data['foto'] = $this->foto->store('alumni', 'public');
        }

        if ($this->editId) {
            Alumni::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Alumni', 'Alumni', $this->editId);
        } else {
            $a = Alumni::create($data);
            ActivityLog::catat('Menambah Alumni', 'Alumni', $a->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Data alumni berhasil disimpan.');
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

        $a = Alumni::findOrFail($id);
        if ($a->foto) {
            Storage::disk('public')->delete($a->foto);
        }
        $a->delete();
        ActivityLog::catat('Menghapus Alumni', 'Alumni', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Data alumni berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.alumni.index', [
            'items' => Alumni::with('kompetensi')->orderByDesc('id')->paginate(10),
            'kompetensiList' => Kompetensi::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }
}