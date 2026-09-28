<?php

namespace App\Livewire\Admin\Ppdb;

use App\Models\PpdbInformation;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public string $tahun_ajaran = '';
    public string $status = 'Dibuka';
    public string $jadwal = '';
    public string $persyaratan = '';
    public string $alur_pendaftaran = '';
    public string $informasi_biaya = '';
    public string $kontak_panitia = '';
    public string $faq = '';
    public string $url_ppdb_resmi = '';
    public $banner = null;

    public function mount()
    {
        $p = PpdbInformation::current();
        $this->tahun_ajaran = $p->tahun_ajaran ?? '';
        $this->status = $p->status ?? 'Dibuka';
        $this->jadwal = $p->jadwal ?? '';
        $this->persyaratan = $p->persyaratan ?? '';
        $this->alur_pendaftaran = $p->alur_pendaftaran ?? '';
        $this->informasi_biaya = $p->informasi_biaya ?? '';
        $this->kontak_panitia = $p->kontak_panitia ?? '';
        $this->faq = $p->faq ?? '';
        $this->url_ppdb_resmi = $p->url_ppdb_resmi ?? '';
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'url_ppdb_resmi' => 'required|url',
            'banner' => 'nullable|image|max:2048',
        ]);

        $data = [
            'tahun_ajaran' => $this->tahun_ajaran,
            'status' => $this->status,
            'jadwal' => \Mews\Purifier\Facades\Purifier::clean($this->jadwal),
            'persyaratan' => \Mews\Purifier\Facades\Purifier::clean($this->persyaratan),
            'alur_pendaftaran' => \Mews\Purifier\Facades\Purifier::clean($this->alur_pendaftaran),
            'informasi_biaya' => $this->informasi_biaya,
            'kontak_panitia' => $this->kontak_panitia,
            'faq' => \Mews\Purifier\Facades\Purifier::clean($this->faq),
            'url_ppdb_resmi' => $this->url_ppdb_resmi,
        ];

        $p = PpdbInformation::current();

        if ($this->banner) {
            if ($p->banner) {
                Storage::disk('public')->delete($p->banner);
            }
            $data['banner'] = \App\Support\ImageUploader::simpan($this->banner, 'ppdb', 1200);
        }

        $p->update($data);
        ActivityLog::catat('Mengubah Informasi PPDB', 'PPDB');
        session()->flash('success', 'Informasi PPDB berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.ppdb.index', [
            'ppdb' => PpdbInformation::current(),
        ]);
    }
}