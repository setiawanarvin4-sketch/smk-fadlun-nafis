<?php

namespace App\Livewire\Admin\HariKhusus;

use App\Models\ActivityLog;
use App\Models\HariKhusus;
use Livewire\Component;

class Index extends Component
{
    public string $tanggal = '';
    public string $jam_pulang = '';
    public string $keterangan = '';

    public function mount()
    {
        $this->tanggal = now()->toDateString();
    }

    public function simpan()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola ini.');

        $this->validate([
            'tanggal' => 'required|date',
            'jam_pulang' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // updateOrCreate: kalau tanggal yang sama diisi ulang (misal jam pulang
        // direvisi di hari yang sama), baris lama ditimpa, bukan dobel.
        HariKhusus::updateOrCreate(
            ['tanggal' => $this->tanggal],
            [
                'jam_pulang' => $this->jam_pulang,
                'keterangan' => $this->keterangan,
                'dibuat_oleh' => auth()->id(),
            ]
        );

        ActivityLog::catat('Menandai Hari Khusus (Pulang Cepat)', 'Hari Khusus');

        $this->dispatch(
            'notify',
            message: 'Tersimpan. Jadwal setelah jam '.$this->jam_pulang.' pada '.
                \Carbon\Carbon::parse($this->tanggal)->translatedFormat('d F Y').
                ' otomatis tidak dianggap "belum absen" lagi.',
            type: 'success'
        );

        $this->reset(['jam_pulang', 'keterangan']);
        $this->tanggal = now()->toDateString();
    }

    public function hapus(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola ini.');

        HariKhusus::findOrFail($id)->delete();

        ActivityLog::catat('Menghapus Hari Khusus', 'Hari Khusus', $id);
        $this->dispatch('notify', message: 'Hari khusus dihapus.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.hari-khusus.index', [
            'daftar' => HariKhusus::orderByDesc('tanggal')->paginate(15),
        ]);
    }
}