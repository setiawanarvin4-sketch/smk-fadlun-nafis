<?php

namespace App\Livewire\Admin\Pengaturan;

use App\Models\PengaturanSitus;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public string $nama_sekolah = '';
    public string $tagline = '';
    public string $alamat = '';
    public string $telepon = '';
    public string $whatsapp = '';
    public string $email = '';
    public string $instagram = '';
    public string $facebook = '';
    public string $youtube = '';
    public string $tiktok = '';
    public ?float $latitude = null;
    public ?float $longitude = null;
    public bool $maintenance_mode = false;
    public bool $wa_notifikasi_aktif = false;
    public string $wa_gateway_token = '';
    public string $wa_gateway_endpoint = '';
    public int $bulan_mulai_ganjil = 7;
    public int $bulan_mulai_genap = 1;
    public $logo = null;

    public function mount()
    {
        $p = PengaturanSitus::current();

        $this->nama_sekolah = $p->nama_sekolah;
        $this->tagline = $p->tagline ?? '';
        $this->alamat = $p->alamat ?? '';
        $this->telepon = $p->telepon ?? '';
        $this->whatsapp = $p->whatsapp ?? '';
        $this->email = $p->email ?? '';
        $this->instagram = $p->instagram ?? '';
        $this->facebook = $p->facebook ?? '';
        $this->youtube = $p->youtube ?? '';
        $this->tiktok = $p->tiktok ?? '';
        $this->latitude = $p->latitude;
        $this->longitude = $p->longitude;
        $this->maintenance_mode = $p->maintenance_mode;
        $this->wa_notifikasi_aktif = $p->wa_notifikasi_aktif;
        $this->wa_gateway_token = $p->wa_gateway_token ?? '';
        $this->wa_gateway_endpoint = $p->wa_gateway_endpoint ?? '';
        $this->bulan_mulai_ganjil = $p->bulan_mulai_ganjil ?: 7;
        $this->bulan_mulai_genap = $p->bulan_mulai_genap ?: 1;
    }

    public function updatedLatitude($value)
    {
        $this->latitude = ($value === '' || $value === null) ? null : (float) $value;
    }

    public function updatedLongitude($value)
    {
        $this->longitude = ($value === '' || $value === null) ? null : (float) $value;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'nama_sekolah' => 'required|string|max:255',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'logo' => 'nullable|image|max:1024',
            'wa_gateway_endpoint' => ['nullable', 'url', 'starts_with:https://'],
            'bulan_mulai_ganjil' => 'required|integer|between:1,12',
            'bulan_mulai_genap' => 'required|integer|between:1,12',
        ]);

        $p = PengaturanSitus::current();

        $data = [
            'nama_sekolah' => $this->nama_sekolah,
            'tagline' => $this->tagline,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'youtube' => $this->youtube,
            'tiktok' => $this->tiktok,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'maintenance_mode' => $this->maintenance_mode,
            'wa_notifikasi_aktif' => $this->wa_notifikasi_aktif,
            'wa_gateway_token' => $this->wa_gateway_token,
            'wa_gateway_endpoint' => $this->wa_gateway_endpoint,
            'bulan_mulai_ganjil' => $this->bulan_mulai_ganjil,
            'bulan_mulai_genap' => $this->bulan_mulai_genap,
        ];

        if ($this->logo) {
            if ($p->logo) {
                Storage::disk('public')->delete($p->logo);
            }
            $data['logo'] = \App\Support\ImageUploader::simpan($this->logo, 'logo', 400);
        }

        $p->update($data);

        \Illuminate\Support\Facades\Cache::forget('pengaturan-situs');
        ActivityLog::catat('Mengubah Pengaturan Website', 'Pengaturan', $p->id);

        session()->flash('success', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.pengaturan.index', [
            'pengaturan' => PengaturanSitus::current(),
        ]);
    }
}