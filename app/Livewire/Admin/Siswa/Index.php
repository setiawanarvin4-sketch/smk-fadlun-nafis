<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Kompetensi;
use App\Models\ActivityLog;
use App\Models\User;
use App\Exports\SiswaExport;
use App\Exports\SiswaTemplateExport;
use App\Imports\SiswaImport;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterKelas = '';
    public string $filterKompetensi = '';

    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $nama = '';
    public string $nis = '';
    public string $nisn = '';
    public string $status_keluar = 'Aktif';
    public ?string $tanggal_keluar = null;
    public ?int $kelas_id = null;
    public ?int $kompetensi_id = null;
    public string $jenis_kelamin = '';
    public string $no_wa_wali = '';
    public bool $aktif = true;
    public $foto = null; // opsional, upload
    public array $ekstraWajib = [];
    public array $ekstraPilihan = [];
    public bool $showModal = false;
    public bool $showExportModal = false;
    public string $exportTingkat = '';
    public ?int $exportKompetensiId = null;
    public string $exportBulanKehadiran = '';

    public bool $showImportModal = false;
    public $fileImport = null;
    public ?int $importBerhasil = null;
    public array $importGagal = [];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterKelas() { $this->resetPage(); }
    public function updatingFilterKompetensi() { $this->resetPage(); }

    public function updatedKelasId($value)
    {
        $this->kompetensi_id = \App\Models\Kelas::find($value)?->kompetensi_id;
    }

    public function create()
    {
        $this->reset(['editId', 'nama', 'nis', 'nisn', 'kelas_id', 'kompetensi_id', 'jenis_kelamin', 'no_wa_wali', 'foto']);
        $this->aktif = true;
        $this->status_keluar = 'Aktif';
        $this->tanggal_keluar = null;
        $this->showModal = true;
        $this->ekstraWajib = [];
        $this->ekstraPilihan = [];
    }

    public function edit(int $id)
    {
        $s = Siswa::findOrFail($id);
        $this->editId = $s->id;
        $this->nama = $s->nama;
        $this->nis = $s->nis ?? '';
        $this->nisn = $s->nisn ?? '';
        $this->kelas_id = $s->kelas_id;
        $this->kompetensi_id = $s->kompetensi_id;
        $this->jenis_kelamin = $s->jenis_kelamin ?? '';
        $this->no_wa_wali = $s->no_wa_wali ?? '';
        $this->aktif = $s->aktif;
        $this->status_keluar = $s->status_keluar ?? 'Aktif';
        $this->tanggal_keluar = $s->tanggal_keluar?->format('Y-m-d');
        $this->foto = null;
        $this->ekstraWajib = $s->ekstraWajib()->pluck('ekstrakurikuler.id')->toArray();
        $this->ekstraPilihan = $s->ekstraPilihan()->pluck('ekstrakurikuler.id')->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');
        $this->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|unique:siswa,nis,'.$this->editId,
            'nisn' => 'nullable|string|unique:siswa,nisn,'.$this->editId,
            'kelas_id' => 'required|exists:kelas,id',
            'kompetensi_id' => 'required|exists:kompetensi,id',
            'jenis_kelamin' => 'nullable|in:L,P',
            'foto' => 'nullable|image|max:500',
        ]);

        $data = [
            'nama' => $this->nama,
            'nis' => $this->nis ?: null,
            'nisn' => $this->nisn ?: null,
            'kelas_id' => $this->kelas_id,
            'kompetensi_id' => $this->kompetensi_id,
            'jenis_kelamin' => $this->jenis_kelamin ?: null,
            'no_wa_wali' => $this->no_wa_wali ?: null,
            'aktif' => $this->aktif,
            'status_keluar' => $this->status_keluar,
            'tanggal_keluar' => $this->tanggal_keluar,
        ];

        if ($this->foto) {
            if ($this->editId) {
                $old = Siswa::find($this->editId)?->foto;
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $data['foto'] = \App\Support\ImageUploader::simpan($this->foto, 'siswa', 400);
        }

        if ($this->editId) {
            $siswaLama = Siswa::findOrFail($this->editId);
            if ($siswaLama->kelas_id !== $this->kelas_id) {
                $kelasLama = \App\Models\Kelas::find($siswaLama->kelas_id)?->nama_kelas ?? '-';
                $kelasBaru = \App\Models\Kelas::find($this->kelas_id)?->nama_kelas ?? '-';
                ActivityLog::catat("Memindah kelas {$siswaLama->nama}: {$kelasLama} -> {$kelasBaru}", 'Siswa', $this->editId);
            }
            $siswaLama->update($data);
            ActivityLog::catat('Mengubah Siswa', 'Siswa', $this->editId);
        } else {
            $s = Siswa::create($data);
            ActivityLog::catat('Menambah Siswa', 'Siswa', $s->id);
            $this->buatAkunSiswa($s);
        }

        $siswaUntukSync = $this->editId ? Siswa::find($this->editId) : $s;
        $syncData = [];
        foreach ($this->ekstraWajib as $id) { $syncData[$id] = ['jenis' => 'Wajib']; }
        foreach ($this->ekstraPilihan as $id) { $syncData[$id] = ['jenis' => 'Pilihan']; }
        $siswaUntukSync->ekstrakurikuler()->sync($syncData);

        $this->showModal = false;
        session()->flash('success', 'Data siswa berhasil disimpan.');
    }

    /**
     * Buat akun login (role: siswa) untuk satu siswa.
     * Password default = NISN (kalau kosong, pakai NIS). Dilewati kalau
     * siswa belum punya NIS/NISN sama sekali (belum bisa login sampai diisi).
     */
    private function buatAkunSiswa(Siswa $siswa): void
    {
        if ($siswa->user_id) {
            return; // sudah punya akun
        }

        $passwordDefault = $siswa->nisn ?: $siswa->nis;
        if (! $passwordDefault) {
            return; // tidak ada NIS/NISN, tidak bisa dibuatkan akun dulu
        }

        $user = User::create([
            'name' => $siswa->nama,
            'email' => 'siswa'.$siswa->id.'@portal.local', // hanya identitas internal, tidak dipakai login
            'password' => $passwordDefault, // otomatis ke-hash (cast 'hashed' di User model)
            'role' => 'siswa',
        ]);

        $siswa->update(['user_id' => $user->id]);
    }

    /**
     * Tombol "Buatkan Akun" untuk siswa lama yang belum punya akun.
     */
    public function generateAkun(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403);

        $siswa = Siswa::findOrFail($id);
        $this->buatAkunSiswa($siswa);

        if ($siswa->fresh()->user_id) {
            session()->flash('success', 'Akun Portal Siswa berhasil dibuat.');
        } else {
            session()->flash('error', 'Gagal: siswa ini belum punya NIS/NISN. Isi salah satunya dulu.');
        }
    }

    /**
     * Tombol "Buatkan Akun untuk Semua" — proses semua siswa aktif yang
     * belum punya akun sekaligus. Yang belum punya NIS/NISN dilewati
     * (dihitung, ditampilkan di pesan hasil).
     */
    public function generateSemuaAkun()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403);

        $kandidat = Siswa::where('aktif', true)->whereNull('user_id')->get();

        $berhasil = 0;
        $dilewati = 0;

        foreach ($kandidat as $siswa) {
            $this->buatAkunSiswa($siswa);
            if ($siswa->fresh()->user_id) {
                $berhasil++;
            } else {
                $dilewati++;
            }
        }

        if ($berhasil === 0 && $dilewati === 0) {
            session()->flash('success', 'Semua siswa aktif sudah punya akun, tidak ada yang perlu dibuatkan.');
        } else {
            $pesan = "Berhasil membuatkan {$berhasil} akun baru.";
            if ($dilewati > 0) {
                $pesan .= " {$dilewati} siswa dilewati karena belum punya NIS maupun NISN — isi salah satunya dulu lalu ulangi.";
            }
            session()->flash('success', $pesan);
        }
    }

    /**
     * Reset password akun siswa kembali ke default (NISN/NIS).
     * Dipakai kalau wali lupa password.
     */
    public function resetPasswordAkun(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403);

        $siswa = Siswa::findOrFail($id);
        if (! $siswa->user_id) {
            session()->flash('error', 'Siswa ini belum punya akun.');
            return;
        }

        $passwordDefault = $siswa->nisn ?: $siswa->nis;
        $siswa->user->update(['password' => $passwordDefault]);
        session()->flash('success', 'Password akun siswa ini di-reset ke default (NISN/NIS).');
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
        Siswa::findOrFail($id)->delete(); // soft delete
        ActivityLog::catat('Menghapus Siswa', 'Siswa', $id);
        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Data siswa berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template-import-siswa.xlsx');
    }

    public function bukaExportModal()
{
    $this->exportTingkat = '';
    $this->exportKompetensiId = null;
    $this->showExportModal = true;
}

    public function exportExcel()
    {
        ActivityLog::catat('Export Data Siswa ke Excel', 'Siswa');

        $namaFile = 'data-siswa';

        if ($this->exportTingkat) {
            $namaFile .= '-kelas'.$this->exportTingkat;
        }

        if ($this->exportKompetensiId) {
            $namaFile .= '-'.\App\Models\Kompetensi::find($this->exportKompetensiId)?->nama;
        }

        $namaFile .= '-'.now()->format('Y-m-d').'.xlsx';

        $this->showExportModal = false;

        return Excel::download(
            new SiswaExport(
                null,
                $this->exportKompetensiId,
                $this->exportTingkat ?: null
            ),
            $namaFile
        );
    }

    public function exportRekapKehadiran()
    {
        ActivityLog::catat('Export Rekap Kehadiran Siswa', 'Siswa');

        $bulan = null;
        $tahun = null;

        if ($this->exportBulanKehadiran) {
            $tanggal = \Carbon\Carbon::parse($this->exportBulanKehadiran . '-01');

            $bulan = $tanggal->month;
            $tahun = $tanggal->year;
        }

        $this->showExportModal = false;

        return Excel::download(
            new \App\Exports\RekapKehadiranSiswaExport(
                $this->filterKelas ?: null,
                $bulan,
                $tahun
            ),
            'rekap-kehadiran-siswa-' .
            ($this->exportBulanKehadiran ?: now()->format('Y-m')) .
            '.xlsx'
        );
    }

    public function openImportModal()
    {
        $this->reset(['fileImport', 'importBerhasil', 'importGagal']);
        $this->showImportModal = true;
    }

    public function importExcel()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengimpor data.');

        $this->validate([
            'fileImport' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $import = new SiswaImport;
        Excel::import($import, $this->fileImport->getRealPath());

        $this->importBerhasil = $import->berhasil;
        $this->importGagal = $import->gagal;
        $this->fileImport = null;

        ActivityLog::catat('Import Data Siswa dari Excel', 'Siswa', null);

        if ($this->importBerhasil > 0) {
            session()->flash('success', "{$this->importBerhasil} data siswa berhasil diimpor.");
        }
    }

    public function render()
    {
        $query = Siswa::with(['kelas', 'kompetensi'])
            ->when($this->search, fn ($q) => $q->where('nama', 'like', '%'.$this->search.'%'))
            ->when($this->filterKelas, fn ($q) => $q->where('kelas_id', $this->filterKelas))
            ->when($this->filterKompetensi, fn ($q) => $q->where('kompetensi_id', $this->filterKompetensi))
            ->orderBy('nama');

        $kompetensiAktif = Kompetensi::where('aktif', true)->orderBy('nama')->get();
        return view('livewire.admin.siswa.index', [
            'items' => $query->paginate(15),
            'kelasList' => Kelas::orderBy('nama_kelas')->get(),
            'kompetensiList' => $kompetensiAktif,
            'kompetensiExportList' => $kompetensiAktif,
            'ekstrakurikulerList' => \App\Models\Ekstrakurikuler::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }
}