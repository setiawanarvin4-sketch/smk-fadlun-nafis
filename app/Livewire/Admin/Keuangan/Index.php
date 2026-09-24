<?php

namespace App\Livewire\Admin\Keuangan;

use App\Models\LaporanKeuangan;
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
    public string $visibilitas = 'internal';
    public string $status = 'draft';
    public $file = null;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'judul', 'deskripsi', 'file']);
        $this->visibilitas = 'internal';
        $this->status = 'draft';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $l = LaporanKeuangan::findOrFail($id);
        $this->editId = $l->id;
        $this->judul = $l->judul;
        $this->deskripsi = $l->deskripsi ?? '';
        $this->visibilitas = $l->visibilitas;
        $this->status = $l->status;
        $this->file = null;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'judul' => 'required|string|max:255',
            'visibilitas' => 'required|in:publik,internal',
            'status' => 'required|in:draft,published',
            'file' => $this->editId ? 'nullable|file|mimes:pdf,xls,xlsx|max:5120' : 'required|file|mimes:pdf,xls,xlsx|max:5120',
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'visibilitas' => $this->visibilitas,
            'status' => $this->status,
            'tanggal' => now()->toDateString(),
        ];

        if ($this->file) {
            if ($this->editId) {
                $old = LaporanKeuangan::find($this->editId)?->file;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['file'] = $this->file->store('keuangan', 'public');
        }

        if ($this->editId) {
            LaporanKeuangan::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Laporan Keuangan', 'Keuangan', $this->editId);
        } else {
            $l = LaporanKeuangan::create($data);
            ActivityLog::catat('Menambah Laporan Keuangan', 'Keuangan', $l->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Laporan keuangan berhasil disimpan.');
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

        $l = LaporanKeuangan::findOrFail($id);
        if ($l->file) {
            Storage::disk('public')->delete($l->file);
        }
        $l->delete();
        ActivityLog::catat('Menghapus Laporan Keuangan', 'Keuangan', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Laporan keuangan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.keuangan.index', [
            'items' => LaporanKeuangan::orderByDesc('id')->paginate(10),
        ]);
    }
}