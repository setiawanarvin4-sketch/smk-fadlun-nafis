<?php

namespace App\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class GantiPassword extends Component
{
    public string $password_lama = '';
    public string $password_baru = '';
    public string $password_baru_konfirmasi = '';
    public string $sukses = '';

    public function simpan()
    {
        $this->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:6',
            'password_baru_konfirmasi' => 'required|same:password_baru',
        ], [
            'password_baru_konfirmasi.same' => 'Konfirmasi password baru tidak cocok.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
        ]);

        $user = Auth::user();

        if (! Hash::check($this->password_lama, $user->password)) {
            $this->addError('password_lama', 'Password lama salah.');
            return;
        }

        $user->update(['password' => $this->password_baru]);

        $this->reset(['password_lama', 'password_baru', 'password_baru_konfirmasi']);
        $this->sukses = 'Password berhasil diganti.';
    }

    public function render()
    {
        return view('livewire.siswa.ganti-password');
    }
}