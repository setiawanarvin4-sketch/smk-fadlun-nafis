<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Kompetensi;
use App\Models\Guru;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editId = null;
    public string $nama_kelas = '';
    public ?int $kompetensi_id = null;
    public ?int $tingkat = null;
    public ?int $wali_kelas_id = null;
    public bool $showModal = false;
    public ?int $konfirmasiHapusId = null;

    public function create()
    {
        $this->reset(['editId', 'nama_kelas', 'kompetensi_id', 'tingkat', 'wali_kelas_id']);
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $k = Kelas::findOrFail($id);
        $this->editId = $k->id;
        $this->nama_kelas = $k->nama_kelas;
        $this->kompetensi_id = $k->kompetensi_id;
        $this->tingkat = $k->tingkat;
        $this->wali_kelas_id = $k->wali_kelas_id;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');
        $this->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,'.$this->editId,
            'kompetensi_id' => 'required|exists:kompetensi,id',
            'tingkat' => 'nullable|integer|min:10|max:12',
            'wali_kelas_id' => 'nullable|exists:guru,id',
        ]);

        $data = [
            'nama_kelas' => $this->nama_kelas,
            'kompetensi_id' => $this->kompetensi_id,
            'tingkat' => $this->tingkat,
            'wali_kelas_id' => $this->wali_kelas_id,
        ];

        if ($this->editId) {
            Kelas::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Kelas', 'Kelas', $this->editId);
        } else {
            $k = Kelas::create($data);
            ActivityLog::catat('Menambah Kelas', 'Kelas', $k->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Data kelas berhasil disimpan.');
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
        Kelas::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Kelas', 'Kelas', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Data kelas berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.kelas.index', [
            'items' => Kelas::with(['kompetensi', 'waliKelas'])
                ->where('nama_kelas', 'like', '%'.$this->search.'%')
                ->orderBy('nama_kelas')
                ->paginate(10),
            'kompetensiList' => Kompetensi::where('aktif', true)->get(),
            'guruList' => Guru::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }
}