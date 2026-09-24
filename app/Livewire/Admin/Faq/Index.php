<?php

namespace App\Livewire\Admin\Faq;

use App\Models\Faq;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $pertanyaan = '';
    public string $jawaban = '';
    public string $kategori = 'Umum';
    public bool $aktif = true;
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'pertanyaan', 'jawaban']);
        $this->kategori = 'Umum';
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $f = Faq::findOrFail($id);
        $this->editId = $f->id;
        $this->pertanyaan = $f->pertanyaan;
        $this->jawaban = $f->jawaban;
        $this->kategori = $f->kategori;
        $this->aktif = $f->aktif;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
            'kategori' => 'required|string|max:100',
        ]);

        $data = [
            'pertanyaan' => $this->pertanyaan,
            'jawaban' => $this->jawaban,
            'kategori' => $this->kategori,
            'aktif' => $this->aktif,
        ];

        if ($this->editId) {
            Faq::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah FAQ', 'Faq', $this->editId);
        } else {
            $f = Faq::create($data);
            ActivityLog::catat('Menambah FAQ', 'Faq', $f->id);
        }

        $this->dispatch('notify', message: 'FAQ berhasil disimpan.', type: 'success');
        $this->showModal = false;
        session()->flash('success', 'FAQ berhasil disimpan.');
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

        Faq::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus FAQ', 'Faq', $id);
        $this->dispatch('notify', message: 'FAQ berhasil dihapus.', type: 'success');
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'FAQ berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.faq.index', [
            'items' => Faq::orderBy('kategori')->orderBy('urutan')->paginate(15),
        ]);
    }
}