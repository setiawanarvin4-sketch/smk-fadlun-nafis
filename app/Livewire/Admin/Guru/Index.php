<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editId = null;
    public ?int $konfirmasiHapusId = null;
    public string $nama = '';
    public string $nip = '';
    public string $email = '';
    public string $jabatan = '';
    public string $bidang = '';
    public string $no_wa = '';
    public string $password = '';
    public bool $aktif = true;
    public bool $konfirmasiNonaktif = false;
    public array $jadwalTerdampak = [];
    public array $mapel_ids = [];
    public bool $showModal = false;

    public function create()
    {
        $this->reset([
            'editId',
            'nama',
            'nip',
            'email',
            'jabatan',
            'bidang',
            'no_wa',
            'password',
            'mapel_ids',
        ]);

        $this->jadwalTerdampak = [];
        $this->aktif = true;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $g = Guru::with('user', 'mataPelajaran')->findOrFail($id);

        $this->editId = $g->id;
        $this->nama = $g->nama;
        $this->nip = $g->nip;
        $this->email = $g->user->email;
        $this->jabatan = $g->jabatan ?? '';
        $this->bidang = $g->bidang ?? '';
        $this->no_wa = $g->no_wa ?? '';
        $this->password = '';
        $this->aktif = $g->aktif;
        $this->mapel_ids = $g->mataPelajaran->pluck('id')->toArray();
        $this->jadwalTerdampak = [];
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengubah data.');

        if ($this->editId && ! $this->aktif && ! $this->konfirmasiNonaktif) {
            $guruLama = Guru::find($this->editId);
            if ($guruLama && $guruLama->aktif) {
                $jadwal = \App\Models\JadwalPelajaran::with(['kelas', 'mataPelajaran'])
                    ->where('guru_id', $this->editId)->where('aktif', true)->get();

                if ($jadwal->count()) {
                    $this->jadwalTerdampak = $jadwal->map(fn ($j) => "{$j->kelas->nama_kelas} — {$j->mataPelajaran->nama} ({$j->hari})")->toArray();
                    return;
                }
            }
        }

        $this->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:guru,nip,' . $this->editId,
            'email' => 'required|email|unique:users,email,' . (
                $this->editId
                    ? Guru::find($this->editId)->user_id
                    : ''
            ),
            'password' => $this->editId
                ? 'nullable|min:8'
                : 'required|min:8',
        ]);

        $data = [
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jabatan' => $this->jabatan,
            'bidang' => $this->bidang,
            'no_wa' => $this->no_wa,
            'aktif' => $this->aktif,
        ];

        if ($this->editId) {
            $guru = Guru::findOrFail($this->editId);

            $guru->user->update([
                'name' => $this->nama,
                'email' => $this->email,
                ...($this->password
                    ? ['password' => $this->password]
                    : []),
            ]);

            $guru->update($data);

            ActivityLog::catat('Mengubah Guru', 'Guru', $guru->id);
        } else {
            $user = User::create([
                'name' => $this->nama,
                'email' => $this->email,
                'password' => $this->password,
                'role' => 'guru',
                'email_verified_at' => now(),
            ]);

            $guru = Guru::create([
                'user_id' => $user->id,
                ...$data,
            ]);

            ActivityLog::catat('Menambah Guru', 'Guru', $guru->id);
        }

        $guru->mataPelajaran()->sync($this->mapel_ids);

        $this->showModal = false;
        session()->flash('success', 'Data guru berhasil disimpan.');
    }

    public function batalkanNonaktif()
    {
        $this->aktif = true;
        $this->jadwalTerdampak = [];
    }
    public function lanjutkanNonaktif()
    {
        $this->konfirmasiNonaktif = true;
        $this->jadwalTerdampak = [];

        $this->save();

        $this->konfirmasiNonaktif = false;
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
        abort_unless(
            \Illuminate\Support\Facades\Gate::allows('kelola-data'),
            403,
            'Kepala Sekolah tidak punya akses menghapus data.'
        );

        $guru = Guru::findOrFail($id);
        $guru->user()->delete();
        $guru->delete();

        ActivityLog::catat('Menghapus Guru', 'Guru', $id);

        $this->konfirmasiHapusId = null;
        session()->flash('success', 'Data guru berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.guru.index', [
            'items' => Guru::where(
                'nama',
                'like',
                '%' . $this->search . '%'
            )
                ->orWhere(
                    'nip',
                    'like',
                    '%' . $this->search . '%'
                )
                ->orderBy('nama')
                ->paginate(10),

            'mapelList' => \App\Models\MataPelajaran::where(
                'aktif',
                true
            )
                ->orderBy('nama')
                ->get(),
        ]);
    }
}