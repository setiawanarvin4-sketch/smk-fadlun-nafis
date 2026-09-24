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
    public bool $showModal = false;

    public function create()
    {
        $this->reset(['editId', 'name', 'email', 'password']);
        $this->role = 'kepala_sekolah';
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $u = User::whereIn('role', ['admin', 'kepala_sekolah'])->findOrFail($id);
        $this->editId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->password = '';
        $this->role = $u->role;
        $this->showModal = true;
    }

    public function save()
    {
        abort_unless(\Illuminate\Support\Facades\Gate::allows('kelola-data'), 403, 'Kepala Sekolah tidak punya akses mengelola akun pengguna.');

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->editId,
            'password' => $this->editId
            ? ['nullable', \Illuminate\Validation\Rules\Password::defaults()]
            : ['required', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => 'required|in:admin,kepala_sekolah',
        ]);

        $data = ['name' => $this->name, 'email' => $this->email, 'role' => $this->role];

        if ($this->password) {
            $data['password'] = $this->password;
        }

        if ($this->editId) {
            User::whereIn('role', ['admin', 'kepala_sekolah'])->findOrFail($this->editId)->update($data);
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

        User::whereIn('role', ['admin', 'kepala_sekolah'])->findOrFail($id)->delete();
        ActivityLog::catat('Menghapus Akun Pengguna', 'User', $id);
        $this->dispatch('notify', message: 'Akun berhasil dihapus.', type: 'success');
        session()->flash('success', 'Akun berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.user.index', [
            'items' => User::whereIn('role', ['admin', 'kepala_sekolah'])->orderBy('name')->paginate(10),
        ]);
    }
}