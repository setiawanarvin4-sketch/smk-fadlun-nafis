<?php

namespace App\Livewire\Admin\JadwalPelajaran;

use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $filterHari = '';
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public ?int $guru_id = null;
    public ?int $kelas_id = null;
    public ?int $mata_pelajaran_id = null;
    public string $hari = 'Senin';
    public string $jam_mulai = '';
    public string $jam_selesai = '';
    public bool $showModal = false;

    public function updatingFilterHari() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['editId', 'guru_id', 'kelas_id', 'mata_pelajaran_id', 'jam_mulai', 'jam_selesai']);
        $this->hari = 'Senin';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $j = JadwalPelajaran::findOrFail($id);
        $this->editId = $j->id;
        $this->guru_id = $j->guru_id;
        $this->kelas_id = $j->kelas_id;
        $this->mata_pelajaran_id = $j->mata_pelajaran_id;
        $this->hari = $j->hari;
        $this->jam_mulai = substr($j->jam_mulai, 0, 5);
        $this->jam_selesai = substr($j->jam_selesai, 0, 5);
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
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $bentrokKelas = JadwalPelajaran::where('kelas_id', $this->kelas_id)
            ->where('hari', $this->hari)
            ->when($this->editId, fn ($q) => $q->where('id', '!=', $this->editId))
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai)
            ->exists();

        if ($bentrokKelas) {
            $this->addError('kelas_id', 'Kelas ini sudah punya jadwal lain yang beririsan waktu di hari yang sama.');
            return;
        }

        $bentrokGuru = JadwalPelajaran::where('guru_id', $this->guru_id)
            ->where('hari', $this->hari)
            ->when($this->editId, fn ($q) => $q->where('id', '!=', $this->editId))
            ->where('jam_mulai', '<', $this->jam_selesai)
            ->where('jam_selesai', '>', $this->jam_mulai)
            ->exists();

        if ($bentrokGuru) {
            $this->addError('guru_id', 'Guru ini sudah punya jadwal mengajar lain yang beririsan waktu di hari yang sama.');
            return;
        }

        $data = [
            'guru_id' => $this->guru_id,
            'kelas_id' => $this->kelas_id,
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'aktif' => true,
        ];

        if ($this->editId) {
            JadwalPelajaran::findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Jadwal Pelajaran', 'JadwalPelajaran', $this->editId);
        } else {
            $j = JadwalPelajaran::create($data);
            ActivityLog::catat('Menambah Jadwal Pelajaran', 'JadwalPelajaran', $j->id);
        }

        $this->showModal = false;
        session()->flash('success', 'Jadwal berhasil disimpan.');
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

        JadwalPelajaran::findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Jadwal Pelajaran', 'JadwalPelajaran', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Jadwal berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.jadwal-pelajaran.index', [
            'items' => JadwalPelajaran::with(['guru', 'kelas', 'mataPelajaran'])
                ->when($this->filterHari, fn ($q) => $q->where('hari', $this->filterHari))
                ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->orderBy('jam_mulai')
                ->paginate(15),
            'guruList' => Guru::where('aktif', true)->orderBy('nama')->get(),
            'kelasList' => Kelas::where('tahun_ajaran', \App\Models\PengaturanSitus::current()->tahun_ajaran_aktif)->orderBy('nama_kelas')->get(),
            'mapelList' => $this->guru_id
                ? Guru::find($this->guru_id)?->mataPelajaran()->where('aktif', true)->orderBy('nama')->get() ?? collect()
                : collect(),
        ]);
    }
}