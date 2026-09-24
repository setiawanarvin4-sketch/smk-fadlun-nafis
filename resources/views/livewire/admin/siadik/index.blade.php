<div>
    <h1 class="text-xl font-semibold text-navy mb-1">Informasi SiAdik</h1>
    <p class="text-sm text-[#667085] mb-4 max-w-2xl">
        SiAdik adalah sistem akademik resmi sekolah, dikelola terpisah dari website ini. Halaman ini hanya
        menampilkan penjelasan singkat + link akses ke SiAdik — bukan tempat login/pakai SiAdik-nya.
    </p>

    <form wire:submit="save" class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4 max-w-2xl mb-6">
        <div>
            <label class="text-sm text-[#667085]">Link Akses SiAdik (wajib)</label>
            <input type="text" wire:model="url_siadik" placeholder="https://siadik.smkfadlunnafis.sch.id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
            @error('url_siadik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="text-sm text-[#667085]">Deskripsi / Keterangan</label>
            <textarea wire:model="deskripsi" rows="5" placeholder="Jelaskan apa itu SiAdik, apa yang bisa diakses di sana, dsb." class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
        </div>

        <div>
            <label class="text-sm text-[#667085]">Tambah Gambar</label>
            <input type="file" wire:model="galeriBaru" multiple accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
            @error('galeriBaru.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <p class="text-xs text-[#667085] mt-1">Bisa pilih beberapa gambar sekaligus (maks 2MB per gambar). Gambar baru ditambahkan saat klik Simpan.</p>
        </div>

        @if(!empty($siadik->galeri))
            <div>
                <label class="text-sm text-[#667085] mb-2 block">Gambar Tersimpan</label>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                    @foreach($siadik->galeri as $i => $path)
                        <div class="relative group">
                            <img src="{{ asset('storage/'.$path) }}" class="w-full h-24 object-cover rounded-lg border border-[#E5E7EB]">
                            <button type="button" wire:click="hapusGambar({{ $i }})" wire:confirm="Hapus gambar ini?"
                                class="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center opacity-90 hover:opacity-100">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-lg text-sm font-semibold">Simpan</button>
    </form>
</div>