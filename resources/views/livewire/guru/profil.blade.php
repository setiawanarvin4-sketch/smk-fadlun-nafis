<div class="space-y-6">
    <div>
        <h1 class="h-sub">Profil Saya</h1>
        <p class="text-sm text-[#667085]">Kelola foto profil dan password akun kamu.</p>
    </div>

    <div class="card-premium hover:-translate-y-0 p-6">
        <div class="flex items-center gap-5">
            @if($foto)
                <img src="{{ $foto->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">
            @elseif($guru->foto)
                <img src="{{ asset('storage/'.$guru->foto) }}" class="w-20 h-20 rounded-full object-cover">
            @else
                <div class="w-20 h-20 rounded-full bg-navy text-white flex items-center justify-center text-2xl font-bold">
                    {{ substr($guru->nama, 0, 1) }}
                </div>
            @endif
            <div>
                <p class="font-bold text-navy">{{ $guru->nama }}</p>
                <p class="text-sm text-[#667085]">{{ $guru->jabatan ?? 'Guru' }} · NIG {{ $guru->nip }}</p>
            </div>
        </div>

        <form wire:submit="simpanFoto" class="mt-5 flex items-end gap-3">
            <div class="flex-1">
                <label class="text-sm text-[#667085]">Ganti Foto Profil</label>
                <input type="file" wire:model="foto" accept="image/*" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1 text-sm">
                <div wire:loading wire:target="foto" class="text-xs text-[#667085] mt-1">Mengunggah...</div>
                @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn-primary !px-4 !py-2 text-sm" @if(!$foto) disabled @endif>Simpan Foto</button>
        </form>
    </div>

    <div class="card-premium hover:-translate-y-0 p-6">
        <p class="font-bold text-navy mb-4">Ganti Password</p>
        <form wire:submit="gantiPassword" class="space-y-4 max-w-sm">
            <div>
                <label class="text-sm text-[#667085]">Password Lama</label>
                <input type="password" wire:model="password_lama" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                @error('password_lama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-[#667085]">Password Baru</label>
                <input type="password" wire:model="password_baru" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
                @error('password_baru') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-[#667085]">Konfirmasi Password Baru</label>
                <input type="password" wire:model="password_baru_confirmation" class="w-full border border-[#E5E7EB] rounded-lg px-3 py-2 mt-1">
            </div>
            <button type="submit" class="btn-primary !px-4 !py-2 text-sm">Ganti Password</button>
        </form>
    </div>
</div>