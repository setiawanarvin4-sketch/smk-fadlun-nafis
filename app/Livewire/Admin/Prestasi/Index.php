<?php

namespace App\Livewire\Admin\Prestasi;

use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kompetensi;
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
    public string $kategori = 'Akademik';
    public string $tingkat = '';
    public string $penyelenggara = '';
    public int $tahun;
    public ?int $siswa_id = null;
    public ?int $kompetensi_id = null;
    public string $deskripsi = '';
    public $foto = null;
    public $foto_sertifikat = null;
    public $foto_dokumentasi = null;
    public ?string $existingFotoSertifikat = null;
    public ?string $existingFotoDokumentasi = null;
    public bool $showModal = false;

    public function mount()
    {
        $this->tahun = now()->year;
    }

    public function updatingSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['editId', 'judul', 'tingkat', 'penyelenggara', 'siswa_id', 'kompetensi_id', 'deskripsi', 'foto', 'foto_sertifikat', 'foto_dokumentasi', 'existingFotoSertifikat', 'existingFotoDokumentasi']);
        $this->kategori = 'Akademik';
        $this->tahun = now()->year;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $p = Prestasi::findOrFail($id);
        $this->editId = $p->id;
        $this->judul = $p->judul;
        $this->kategori = $p->kategori;
        $this->tingkat = $p->tingkat ?? '';
        $this->penyelenggara = $p->penyelenggara ?? '';
        $this->tahun = $p->tahun;
        $this->siswa_id = $p->siswa_id;
        $this->kompetensi_id = $p->kompetensi_id;
        $this->deskripsi = $p->deskripsi ?? '';
        $this->foto = null;
        $this->foto_sertifikat = null;
        $this->foto_dokumentasi = null;
        $this->existingFotoSertifikat = $p->foto_sertifikat;
        $this->existingFotoDokumentasi = $p->foto_dokumentasi;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Akademik,Non-Akademik',
            'tahun' => 'required|integer|min:2000|max:2100',
            'foto' => 'nullable|image|max:5120',
            'foto_sertifikat' => 'nullable|image|max:5120',
            'foto_dokumentasi' => 'nullable|image|max:5120',
        ]);

        $data = [
            'judul' => $this->judul,
            'kategori' => $this->kategori,
            'tingkat' => $this->tingkat,
            'penyelenggara' => $this->penyelenggara,
            'tahun' => $this->tahun,
            'siswa_id' => $this->siswa_id ?: null,
            'kompetensi_id' => $this->kompetensi_id ?: null,
            'deskripsi' => $this->deskripsi,
        ];

        $existing = $this->editId ? Prestasi::find($this->editId) : null;

        if ($this->foto) {
            if ($existing?->foto) {
                Storage::disk('public')->delete($existing->foto);
            }
            $data['foto'] = $this->foto->store('prestasi', 'public');
        }
        if ($this->foto_sertifikat) {
            if ($existing?->foto_sertifikat) {
                Storage::disk('public')->delete($existing->foto_sertifikat);
            }
            $data['foto_sertifikat'] = $this->foto_sertifikat->store('prestasi/sertifikat', 'public');
        }
        if ($this->foto_dokumentasi) {
            if ($existing?->foto_dokumentasi) {
                Storage::disk('public')->delete($existing->foto_dokumentasi);
            }
            $data['foto_dokumentasi'] = $this->foto_dokumentasi->store('prestasi/dokumentasi', 'public');
        }

        if ($this->editId) {
            Prestasi::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Prestasi', 'Prestasi', $this->editId);
        } else {
            $p = Prestasi::create($data);
            ActivityLog::catat('Menambah Prestasi', 'Prestasi', $p->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Prestasi berhasil disimpan.');
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

        $p = Prestasi::findOrFail($id);
        if ($p->foto) {
            Storage::disk('public')->delete($p->foto);
        }
        if ($p->foto_sertifikat) {
            Storage::disk('public')->delete($p->foto_sertifikat);
        }
        if ($p->foto_dokumentasi) {
            Storage::disk('public')->delete($p->foto_dokumentasi);
        }
        $p->delete();
        ActivityLog::catat('Menghapus Prestasi', 'Prestasi', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Prestasi berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.prestasi.index', [
            'items' => Prestasi::with('siswa')->where('judul', 'like', '%'.$this->search.'%')->orderByDesc('tahun')->paginate(10),
            'siswaList' => Siswa::orderBy('nama')->get(),
            'kompetensiList' => Kompetensi::where('aktif', true)->get(),
        ]);
    }
}