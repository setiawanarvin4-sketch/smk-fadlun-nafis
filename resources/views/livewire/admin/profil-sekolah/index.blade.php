<div>
    <h1 class="text-xl font-semibold text-navy mb-4">Profil Sekolah</h1>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <!-- FORM PROFIL SEKOLAH -->
    <form wire:submit="saveProfil" class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4 max-w-2xl mb-6">
        <p class="text-sm font-semibold text-navy">Profil, Sejarah & Struktur</p>
        <div>
            <label class="text-sm text-[#667085]">Foto Sampul (background di bagian atas halaman Profil & Guru)</label>
            <input type="file" wire:model="header_gambar" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
            <div wire:loading wire:target="header_gambar" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
            @error('header_gambar')
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded p-3 mt-2">
                    ⚠️ {{ $message }} <strong>Seluruh form ini belum tersimpan</strong> selama error ini muncul — perbaiki dulu foto sampulnya (atau kosongkan field-nya), baru klik Simpan lagi.
                </div>
            @enderror
            @if($existingHeaderGambar)
                <img src="{{ asset('storage/'.$existingHeaderGambar) }}" class="w-40 h-24 object-cover rounded mt-2">
            @endif
        </div>
        <div>
            <label class="text-sm text-[#667085]">Link Video Profil (opsional — tampil di Beranda)</label>
            <input type="url" wire:model="video_profil_url" placeholder="https://www.youtube.com/watch?v=xxxxxxx"
                   class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
            <p class="text-xs text-[#667085] mt-1">Tempel link video YouTube (atau link video lain yang bisa di-embed). Kosongkan kalau belum ada / tidak ingin ditampilkan.</p>
            @error('video_profil_url')
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded p-3 mt-2">⚠️ {{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="text-sm text-[#667085]">Profil Sekolah</label>
            <textarea wire:model="profil" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
        </div>
        <div>
            <label class="text-sm text-[#667085]">Sejarah</label>
            <textarea wire:model="sejarah" rows="4" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-[#667085]">Visi</label>
                <textarea wire:model="visi" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Misi</label>
                <textarea wire:model="misi" rows="2" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
        </div>
        <div>
            <label class="text-sm text-[#667085]">Motto</label>
            <input type="text" wire:model="motto" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="text-sm text-[#667085]">Struktur Organisasi</label>
            <textarea wire:model="struktur_organisasi" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
        </div>
        <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-lg text-sm font-semibold">Simpan Profil</button>
    </form>

    <!-- FORM SAMBUTAN KEPSEK -->
    <form wire:submit="saveSambutan" class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4 max-w-2xl">
        <p class="text-sm font-semibold text-navy">Sambutan Kepala Sekolah</p>
        <div>
            <label class="text-sm text-[#667085]">Foto</label>
            @if($sambutanSaatIni->foto)
                <img src="{{ asset('storage/'.$sambutanSaatIni->foto) }}" class="w-16 h-16 rounded-full object-cover border border-[#E5E7EB] mt-1 mb-2">
            @endif
            <input type="file" wire:model="sambutan_foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-[#667085]">Nama</label>
                <input type="text" wire:model="sambutan_nama" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm text-[#667085]">Jabatan</label>
                <input type="text" wire:model="sambutan_jabatan" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
            </div>
        </div>
        <div>
            <label class="text-sm text-[#667085]">Judul Sambutan</label>
            <input type="text" wire:model="sambutan_judul" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
        </div>
        <div>
            <label class="text-sm text-[#667085]">Isi Sambutan</label>
            <textarea wire:model="sambutan_isi" rows="5" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
        </div>
        <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-lg text-sm font-semibold">Simpan Sambutan</button>
    </form>
</div>