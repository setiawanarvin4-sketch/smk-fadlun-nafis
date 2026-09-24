<div>
    <h1 class="text-xl font-semibold text-navy mb-4">Informasi PPDB</h1>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 text-sm rounded p-3 mb-4">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="space-y-4 max-w-2xl">
        <div class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4">
            <p class="text-sm font-semibold text-navy">Info Umum</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm text-[#667085]">Tahun Ajaran</label>
                    <input type="text" wire:model="tahun_ajaran" placeholder="2026/2027" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm text-[#667085]">Status</label>
                    <select wire:model="status" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                        <option value="Dibuka">Dibuka</option>
                        <option value="Ditutup">Ditutup</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-sm text-[#667085]">URL PPDB Resmi (wajib)</label>
                <input type="text" wire:model="url_ppdb_resmi" placeholder="https://ppdb.smkfadlunnafis.sch.id" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                @error('url_ppdb_resmi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-[#667085]">Kontak Panitia</label>
                <input type="text" wire:model="kontak_panitia" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm text-[#667085]">Banner (opsional)</label>
                <input type="file" wire:model="banner" accept="image/*" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1 text-sm">
                @if($ppdb->banner)
                    <img src="{{ asset('storage/'.$ppdb->banner) }}" class="w-32 mt-1 rounded">
                @endif
            </div>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4">
            <p class="text-sm font-semibold text-navy">Detail PPDB</p>
            <div>
                <label class="text-sm text-[#667085]">Jadwal Pendaftaran</label>
                <textarea wire:model="jadwal" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Persyaratan</label>
                <textarea wire:model="persyaratan" rows="4" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Alur Pendaftaran</label>
                <textarea wire:model="alur_pendaftaran" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div>
                <label class="text-sm text-[#667085]">Informasi Biaya</label>
                <textarea wire:model="informasi_biaya" rows="3" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
            <div>
                <label class="text-sm text-[#667085]">FAQ</label>
                <textarea wire:model="faq" rows="4" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1"></textarea>
            </div>
        </div>

        <button type="submit" class="bg-navy text-white px-6 py-3 rounded-lg text-sm font-semibold">Simpan PPDB</button>
    </form>
</div>