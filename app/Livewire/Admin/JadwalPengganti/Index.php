<?php

namespace App\Livewire\Admin\JadwalPengganti;

use App\Models\JadwalPengganti;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public ?int $guru_id = null;
    public ?int $kelas_id = null;
    public ?int $mata_pelajaran_id = null;
    public string $tanggal = '';
    public string $jam_mulai = '';
    public string $jam_selesai = '';
    public string $keterangan = '';
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'guru_id', 'kelas_id', 'mata_pelajaran_id', 'jam_mulai', 'jam_selesai', 'keterangan']);
        $this->tanggal = now()->toDateString();
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $j = JadwalPengganti::findOrFail($id);
        $this->editId = $j->id;
        $this->guru_id = $j->guru_id;
        $this->kelas_id = $j->kelas_id;
        $this->mata_pelajaran_id = $j->mata_pelajaran_id;
        $this->tanggal = $j->tanggal->toDateString();
        $this->jam_mulai = substr($j->jam_mulai, 0, 5);
        $this->jam_selesai = substr($j->jam_selesai, 0, 5);
        $this->keterangan = $j->keterangan ?? '';
        $this->showModal = true;
    }

    public function updatedGuruId($value)
    {
        $this->mata_pelajaran_id = null;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        $this->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $bentrokKelas = JadwalPengganti::where('kelas_id', $this->kelas_id)
            ->where('tanggal', $this->tanggal)
            ->when($this->editId, fn ($q) => $q->where('id', '!=', $this->editId))
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai)
            ->exists();

        if ($bentrokKelas) {
            $this->addError('kelas_id', 'Kelas ini sudah punya jadwal pengganti lain yang beririsan waktu di tanggal yang sama.');
            return;
        }

        $bentrokGuru = JadwalPengganti::where('guru_id', $this->guru_id)
            ->where('tanggal', $this->tanggal)
            ->when($this->editId, fn ($q) => $q->where('id', '!=', $this->editId))
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai)
            ->exists();

        if ($bentrokGuru) {
            $this->addError('guru_id', 'Guru ini sudah punya jadwal lain yang beririsan waktu di tanggal yang sama.');
            return;
        }

        $data = [
            'guru_id' => $this->guru_id,
            'kelas_id' => $this->kelas_id,
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'keterangan' => $this->keterangan,
        ];

        if ($this->editId) {
            JadwalPengganti::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Jadwal Pengganti', 'JadwalPengganti', $this->editId);
        } else {
            $j = JadwalPengganti::create($data);
            ActivityLog::catat('Menambah Jadwal Pengganti', 'JadwalPengganti', $j->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Jadwal pengganti berhasil disimpan.');
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

        JadwalPengganti::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Jadwal Pengganti', 'JadwalPengganti', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Jadwal pengganti berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.jadwal-pengganti.index', [
            'items' => JadwalPengganti::with(['guru', 'kelas', 'mataPelajaran'])
                ->orderByDesc('tanggal')
                ->paginate(15),
            'guruList' => Guru::where('aktif', true)->orderBy('nama')->get(),
            'kelasList' => Kelas::where('tahun_ajaran', \App\Models\PengaturanSitus::current()->tahun_ajaran_aktif)->orderBy('nama_kelas')->get(),
            'mapelList' => $this->guru_id
                ? \App\Models\Guru::find($this->guru_id)?->mataPelajaran()->where('aktif', true)->orderBy('nama')->get() ?? collect()
                : collect(),
        ]);
    }
}