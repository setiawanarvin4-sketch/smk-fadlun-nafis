<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{
    use WithFileUploads;

    public $foto = null;
    public string $password_lama = '';
    public string $password_baru = '';
    public string $password_baru_confirmation = '';

    public function simpanFoto()
    {
        $this->validate(['foto' => 'required|image|max:5120']);

        $guru = Guru::where('user_id', auth()->id())->firstOrFail();

        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->update(['foto' => $this->foto->store('guru', 'public')]);

        ActivityLog::catat('Mengubah Foto Profil', 'Guru', $guru->id);
        $this->dispatch('notify', message: 'Foto profil berhasil diperbarui.', type: 'success');
        $this->foto = null;
    }

    public function gantiPassword()
    {
        $this->validate([
            'password_lama' => 'required',
            'password_baru' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = auth()->user();

        if (! Hash::check($this->password_lama, $user->password)) {
            $this->addError('password_lama', 'Password lama tidak sesuai.');
            return;
        }

        $user->update(['password' => $this->password_baru]);

        ActivityLog::catat('Mengganti Password', 'Guru', $user->id);
        $this->dispatch('notify', message: 'Password berhasil diganti.', type: 'success');
        $this->reset(['password_lama', 'password_baru', 'password_baru_confirmation']);
    }

    public function render()
    {
        return view('livewire.guru.profil', [
            'guru' => Guru::where('user_id', auth()->id())->firstOrFail(),
        ]);
    }
}