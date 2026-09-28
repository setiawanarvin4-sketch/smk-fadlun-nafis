<?php

namespace App\Livewire\Admin\Absensi;

use App\Models\SesiMengajar;
use App\Models\GuruTidakHadir;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $filterKelas = '';
    public string $filterGuru = '';
    public string $filterTanggal = '';
    public string $exportBulan = '';

    public bool $showDetail = false;
    public ?SesiMengajar $detailSesi = null;

    public bool $showTidakHadirDetail = false;
    public $detailTidakHadir = null;

    public function updatingFilterKelas() { $this->resetPage(); }
    public function updatingFilterGuru() { $this->resetPage(); }
    public function updatingFilterTanggal() { $this->resetPage(); }

    public function openDetail(int $sesiId)
    {
        $this->detailSesi = SesiMengajar::with(['guru', 'kelas', 'mataPelajaran', 'absensi.siswa'])->find($sesiId);
        $this->showDetail = true;
    }

    public function openTidakHadirDetail(int $id)
    {
        $this->detailTidakHadir = GuruTidakHadir::with('guru', 'kelas', 'mataPelajaran')->find($id);
        $this->showTidakHadirDetail = true;
    }

    public function setujuiTidakHadir(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses melakukan ini.');

        ActivityLog::catat('Menyetujui izin guru', 'Absensi', $id);
        GuruTidakHadir::where('id', $id)->update(['status' => 'Disetujui']);
        if ($this->detailTidakHadir?->id === $id) {
            $this->detailTidakHadir->status = 'Disetujui';
        }
        session()->flash('success', 'Laporan ketidakhadiran guru disetujui.');
    }

    public function tolakTidakHadir(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses melakukan ini.');

        ActivityLog::catat('Menolak izin guru', 'Absensi', $id);
        GuruTidakHadir::where('id', $id)->update(['status' => 'Ditolak']);
        if ($this->detailTidakHadir?->id === $id) {
            $this->detailTidakHadir->status = 'Ditolak';
        }
        session()->flash('success', 'Laporan ketidakhadiran guru ditolak.');
    }

    public function batalkanSesi(int $sesiId)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403);

        $sesi = \App\Models\SesiMengajar::findOrFail($sesiId);

        \App\Models\Absensi::where('sesi_mengajar_id', $sesiId)->delete();
        $sesi->delete();

        ActivityLog::catat('Membatalkan Sesi Mengajar (salah pilih kelas)', 'Absensi', $sesiId);
        session()->flash('success', 'Sesi berhasil dibatalkan. Guru bisa memilih jadwal yang benar lagi.');
        $this->dispatch('$refresh');
    }

    public function exportExcel()
    {
        ActivityLog::catat('Export Rekap Absensi ke Excel', 'Absensi');
        $mulai = null;
        $selesai = null;

        if ($this->exportBulan) {
            $awal = \Carbon\Carbon::parse($this->exportBulan.'-01');
            $mulai = $awal->copy()->startOfMonth()->toDateString();
            $selesai = $awal->copy()->endOfMonth()->toDateString();
        }

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AbsensiExport($this->filterKelas ?: null, $this->filterGuru ?: null, $mulai, $selesai),
            'rekap-absensi-'.($this->exportBulan ?: 'semua').'.xlsx'
        );
    }

    public function render()
    {
        $query = SesiMengajar::with(['guru', 'kelas', 'mataPelajaran', 'absensi'])
            ->when($this->filterKelas, fn ($q) => $q->where('kelas_id', $this->filterKelas))
            ->when($this->filterGuru, fn ($q) => $q->where('guru_id', $this->filterGuru))
            ->when($this->filterTanggal, fn ($q) => $q->where('tanggal', $this->filterTanggal))
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai');

        $tidakHadirList = GuruTidakHadir::with('kelas', 'guru', 'mataPelajaran')
            ->when($this->filterKelas, fn ($q) => $q->where('kelas_id', $this->filterKelas))
            ->when($this->filterGuru, fn ($q) => $q->where('guru_id', $this->filterGuru))
            ->when($this->filterTanggal, fn ($q) => $q->where('tanggal', $this->filterTanggal))
            ->orderByDesc('tanggal')
            ->get();

        return view('livewire.admin.absensi.index', [
            'items' => $query->paginate(15),
            'tidakHadirList' => $tidakHadirList,
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
            'guruList' => Guru::orderBy('nama')->get(),
        ]);
    }
    public function exportRekapGuruBulanan()
    {
        ActivityLog::catat('Export Rekap Guru Bulanan', 'Absensi');
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RekapKehadiranGuruBulananExport(now()->month, now()->year),
            'rekap-guru-'.now()->format('Y-m').'.xlsx'
        );
    }
}