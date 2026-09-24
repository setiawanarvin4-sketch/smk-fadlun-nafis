<?php

namespace App\Livewire\Admin\ProfilSekolah;

use App\Models\ProfilSekolah as ProfilModel;
use App\Models\SambutanKepsek;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public string $profil = '';
    public string $sejarah = '';
    public string $visi = '';
    public string $misi = '';
    public string $motto = '';
    public string $struktur_organisasi = '';
    public string $info_tata_usaha = '';
    public $header_gambar = null;
    public ?string $existingHeaderGambar = null;

    public string $sambutan_judul = '';
    public string $sambutan_nama = '';
    public string $sambutan_jabatan = '';
    public string $sambutan_isi = '';
    public $sambutan_foto = null;

    public function mount()
    {
        $p = ProfilModel::current();
        $this->profil = $p->profil ?? '';
        $this->sejarah = $p->sejarah ?? '';
        $this->visi = $p->visi ?? '';
        $this->misi = $p->misi ?? '';
        $this->motto = $p->motto ?? '';
        $this->struktur_organisasi = $p->struktur_organisasi ?? '';
        $this->info_tata_usaha = $p->info_tata_usaha ?? '';
        $this->existingHeaderGambar = $p->header_gambar;

        $s = SambutanKepsek::current();
        $this->sambutan_judul = $s->judul ?? '';
        $this->sambutan_nama = $s->nama ?? '';
        $this->sambutan_jabatan = $s->jabatan ?? '';
        $this->sambutan_isi = $s->isi ?? '';
    }

    public function saveProfil()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'header_gambar' => 'nullable|image|max:5120',
        ], [
            'header_gambar.max' => 'Ukuran foto sampul maksimal 5MB. File kamu terlalu besar, coba kompres dulu atau pakai foto lain.',
            'header_gambar.image' => 'File yang diupload harus berupa gambar (jpg, png, dll).',
        ]);

        $data = [
            'profil' => $this->profil,
            'sejarah' => \Mews\Purifier\Facades\Purifier::clean($this->sejarah),
            'visi' => $this->visi,
            'misi' => \Mews\Purifier\Facades\Purifier::clean($this->misi),
            'motto' => $this->motto,
            'struktur_organisasi' => \Mews\Purifier\Facades\Purifier::clean($this->struktur_organisasi),
            'info_tata_usaha' => $this->info_tata_usaha,
        ];

        $p = ProfilModel::current();

        if ($this->header_gambar) {
            if ($p->header_gambar) {
                Storage::disk('public')->delete($p->header_gambar);
            }
            $data['header_gambar'] = $this->header_gambar->store('profil-sekolah', 'public');
        }

        $p->update($data);
        \Illuminate\Support\Facades\Cache::forget('profil-sekolah-hero');
        $this->header_gambar = null;
        $this->existingHeaderGambar = $p->fresh()->header_gambar;

        ActivityLog::catat('Mengubah Profil Sekolah', 'ProfilSekolah');
        session()->flash('success', 'Profil sekolah berhasil disimpan.');
    }

    public function saveSambutan()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $data = [
            'judul' => $this->sambutan_judul,
            'nama' => $this->sambutan_nama,
            'jabatan' => $this->sambutan_jabatan,
            'isi' => \Mews\Purifier\Facades\Purifier::clean($this->sambutan_isi),
        ];

        $s = SambutanKepsek::current();

        if ($this->sambutan_foto) {
            if ($s->foto) {
                Storage::disk('public')->delete($s->foto);
            }
            $data['foto'] = $this->sambutan_foto->store('sambutan', 'public');
        }

        $s->update($data);

        ActivityLog::catat('Mengubah Sambutan Kepala Sekolah', 'SambutanKepsek');
        session()->flash('success', 'Sambutan kepala sekolah berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.profil-sekolah.index', [
            'sambutanSaatIni' => SambutanKepsek::current(),
        ]);
    }
}