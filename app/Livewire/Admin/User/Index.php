<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $editId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'kepala_sekolah';
    public string $nama_pena = '';
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'name', 'email', 'password']);
        $this->role = 'kepala_sekolah';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola akun pengguna.');

        $u = User::whereIn('role', ['admin', 'kepala_sekolah', 'jurnalistik'])->findOrFail($id);
        $this->editId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->password = '';
        $this->role = $u->role;
        $this->nama_pena = $u->nama_pena ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola akun pengguna.');

        if ($this->editId && $this->editId === auth()->id() && $this->role !== 'admin') {
            $this->addError('role', 'Anda tidak bisa mengubah role akun sendiri dari Admin.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->editId,
            'password' => $this->editId
            ? ['nullable', \Illuminate\Validation\Rules\Password::defaults()]
            : ['required', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => 'required|in:admin,kepala_sekolah,jurnalistik',
            'nama_pena' => 'nullable|string|max:100',
        ]);

        $data = ['name' => $this->name, 'email' => $this->email, 'role' => $this->role, 'nama_pena' => $this->nama_pena ?: null];

        if ($this->password) {
            $data['password'] = $this->password;
        }

        if ($this->editId) {
            User::whereIn('role', ['admin', 'kepala_sekolah', 'jurnalistik'])->findOrFail($this->editId)->update($data);
            ActivityLog::catat('Mengubah Akun Pengguna', 'User', $this->editId);
        } else {
            $u = User::create($data);
            ActivityLog::catat('Menambah Akun Pengguna', 'User', $u->id);
        }

        $this->dispatch('notify', message: 'Akun berhasil disimpan.', type: 'success');
        $this->showModal = false;
        session()->flash('success', 'Akun berhasil disimpan.');
    }

    public function delete(int $id)
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola akun pengguna.');

        if ($id === auth()->id()) {
            $this->dispatch('notify', message: 'Kamu tidak bisa menghapus akunmu sendiri.', type: 'error');
            return;
        }

        User::whereIn('role', ['admin', 'kepala_sekolah', 'jurnalistik'])->findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Akun Pengguna', 'User', $id);
        $this->dispatch('notify', message: 'Akun berhasil dihapus.', type: 'success');
        session()->flash('success', 'Akun berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.user.index', [
            'items' => User::whereIn('role', ['admin', 'kepala_sekolah', 'jurnalistik'])->orderBy('name')->paginate(10),
        ]);
    }
}