<?php

namespace App\Livewire\Admin\StatistikSekolah;

use App\Models\StatistikSekolah;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $label = '';
    public string $nilai = '';
    public int $urutan = 0;
    public bool $aktif = true;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'label', 'nilai']);
        $this->urutan = StatistikSekolah::max('urutan') + 1;
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $s = StatistikSekolah::findOrFail($id);
        $this->editId = $s->id;
        $this->label = $s->label;
        $this->nilai = $s->nilai;
        $this->urutan = $s->urutan;
        $this->aktif = $s->aktif;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'label' => 'required|string|max:255',
            'nilai' => 'required|string|max:50',
        ]);

        $data = [
            'label' => $this->label,
            'nilai' => $this->nilai,
            'urutan' => $this->urutan,
            'aktif' => $this->aktif,
        ];

        if ($this->editId) {
            StatistikSekolah::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Statistik Sekolah', 'StatistikSekolah', $this->editId);
        } else {
            $s = StatistikSekolah::create($data);
            ActivityLog::catat('Menambah Statistik Sekolah', 'StatistikSekolah', $s->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Statistik berhasil disimpan.');
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

        StatistikSekolah::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Statistik Sekolah', 'StatistikSekolah', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Statistik berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.statistik-sekolah.index', [
            'items' => StatistikSekolah::orderBy('urutan')->paginate(10),
        ]);
    }
}