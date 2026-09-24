<?php

namespace App\Livewire\Admin\Siadik;

use App\Models\ActivityLog;
use App\Models\SiadikInformation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public string $deskripsi = '';
    public string $url_siadik = '';

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $galeriBaru = [];

    public function mount()
    {
        $s = SiadikInformation::current();
        $this->deskripsi = $s->deskripsi ?? '';
        $this->url_siadik = $s->url_siadik ?? '';
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'url_siadik' => 'required|url',
            'galeriBaru.*' => 'nullable|image|max:2048',
        ]);

        $s = SiadikInformation::current();
        $galeri = $s->galeri ?? [];

        foreach ($this->galeriBaru as $file) {
            $galeri[] = $file->store('siadik', 'public');
        }

        $s->update([
            'deskripsi' => \Mews\Purifier\Facades\Purifier::clean($this->deskripsi),
            'url_siadik' => $this->url_siadik,
            'galeri' => array_values($galeri),
        ]);

        $this->galeriBaru = [];

        ActivityLog::catat('Mengubah Informasi SiAdik', 'SiAdik');
        $this->dispatch('notify', message: 'Informasi SiAdik berhasil disimpan.', type: 'success');
    }

    public function hapusGambar(int $index)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $s = SiadikInformation::current();
        $galeri = $s->galeri ?? [];

        if (isset($galeri[$index])) {
            Storage::disk('public')->delete($galeri[$index]);
            unset($galeri[$index]);
            $s->update(['galeri' => array_values($galeri)]);
        }

        $this->dispatch('notify', message: 'Gambar dihapus.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.siadik.index', [
            'siadik' => SiadikInformation::current(),
        ]);
    }
}