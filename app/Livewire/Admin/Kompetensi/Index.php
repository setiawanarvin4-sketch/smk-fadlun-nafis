<?php

namespace App\Livewire\Admin\Kompetensi;

use App\Models\Kompetensi;
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
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $nama = '';
    public string $deskripsi = '';
    public string $visi = '';
    public string $misi = '';
    public string $profil_singkat = '';
    public string $prospek_karir = '';
    public string $kepala_jurusan_nama = '';
    public string $kepala_jurusan_jabatan = '';
    public bool $aktif = true;
    public $foto = null;
    public ?string $existingFoto = null;
    public $foto_kegiatan_1 = null;
    public $foto_kegiatan_2 = null;
    public $foto_kegiatan_3 = null;
    public ?string $existingFotoKegiatan1 = null;
    public ?string $existingFotoKegiatan2 = null;
    public ?string $existingFotoKegiatan3 = null;
    public $kepala_jurusan_foto = null;
    public ?string $existingKepalaFoto = null;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'nama', 'deskripsi', 'visi', 'misi', 'prospek_karir', 'profil_singkat', 'kepala_jurusan_nama', 'kepala_jurusan_jabatan', 'foto', 'existingFoto', 'kepala_jurusan_foto', 'existingKepalaFoto', 'foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3', 'existingFotoKegiatan1', 'existingFotoKegiatan2', 'existingFotoKegiatan3']);
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $k = Kompetensi::findOrFail($id);
        $this->editId = $k->id;
        $this->nama = $k->nama;
        $this->deskripsi = $k->deskripsi ?? '';
        $this->visi = $k->visi ?? '';
        $this->misi = $k->misi ?? '';
        $this->profil_singkat = $k->profil_singkat ?? '';
        $this->prospek_karir = $k->prospek_karir ?? '';
        $this->kepala_jurusan_nama = $k->kepala_jurusan_nama ?? '';
        $this->kepala_jurusan_jabatan = $k->kepala_jurusan_jabatan ?? 'Kepala Kompetensi Keahlian';
        $this->aktif = $k->aktif;
        $this->foto = null;
        $this->existingFoto = $k->foto;
        $this->foto_kegiatan_1 = null;
        $this->foto_kegiatan_2 = null;
        $this->foto_kegiatan_3 = null;
        $this->existingFotoKegiatan1 = $k->foto_kegiatan_1;
        $this->existingFotoKegiatan2 = $k->foto_kegiatan_2;
        $this->existingFotoKegiatan3 = $k->foto_kegiatan_3;
        $this->kepala_jurusan_foto = null;
        $this->existingKepalaFoto = $k->kepala_jurusan_foto;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'profil_singkat' => 'nullable|string',
            'prospek_karir' => 'nullable|string',
            'kepala_jurusan_nama' => 'nullable|string|max:255',
            'kepala_jurusan_jabatan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:5120',
            'kepala_jurusan_foto' => 'nullable|image|max:5120',
            'foto_kegiatan_1' => 'nullable|image|max:5120',
            'foto_kegiatan_2' => 'nullable|image|max:5120',
            'foto_kegiatan_3' => 'nullable|image|max:5120',
        ]);

        $data = [
            'nama' => $this->nama,
            'slug' => Str::slug($this->nama),
            'deskripsi' => $this->deskripsi,
            'visi' => $this->visi,
            'misi' => $this->misi,
            'profil_singkat' => $this->profil_singkat,
            'prospek_karir' => $this->prospek_karir,
            'kepala_jurusan_nama' => $this->kepala_jurusan_nama,
            'kepala_jurusan_jabatan' => $this->kepala_jurusan_jabatan ?: 'Kepala Kompetensi Keahlian',
            'aktif' => $this->aktif,
        ];

        $existing = $this->editId ? Kompetensi::find($this->editId) : null;

        if ($this->foto) {
            if ($existing?->foto) {
                Storage::disk('public')->delete($existing->foto);
            }
            $data['foto'] = $this->foto->store('kompetensi', 'public');
        }
        if ($this->kepala_jurusan_foto) {
            if ($existing?->kepala_jurusan_foto) {
                Storage::disk('public')->delete($existing->kepala_jurusan_foto);
            }
            $data['kepala_jurusan_foto'] = $this->kepala_jurusan_foto->store('kompetensi/kepala', 'public');
        }
        foreach (['foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3'] as $field) {
            if ($this->$field) {
                if ($existing?->$field) {
                    Storage::disk('public')->delete($existing->$field);
                }
                $data[$field] = $this->$field->store('kompetensi/kegiatan', 'public');
            }
        }

        if ($this->editId) {
            Kompetensi::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Kompetensi', 'Kompetensi', $this->editId);
        } else {
            $k = Kompetensi::create($data + ['urutan' => Kompetensi::max('urutan') + 1]);
            ActivityLog::catat('Menambah Kompetensi', 'Kompetensi', $k->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Data kompetensi berhasil disimpan.');
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

        $k = Kompetensi::findOrFail($id);
        if ($k->foto) {
            Storage::disk('public')->delete($k->foto);
        }
        if ($k->kepala_jurusan_foto) {
            Storage::disk('public')->delete($k->kepala_jurusan_foto);
        }
        foreach (['foto_kegiatan_1', 'foto_kegiatan_2', 'foto_kegiatan_3'] as $field) {
            if ($k->$field) {
                Storage::disk('public')->delete($k->$field);
            }
        }
        $k->delete();
        ActivityLog::catat('Menghapus Kompetensi', 'Kompetensi', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Data kompetensi berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.kompetensi.index', [
            'items' => Kompetensi::where('nama', 'like', '%'.$this->search.'%')
                ->orderBy('urutan')
                ->paginate(10),
        ]);
    }
}