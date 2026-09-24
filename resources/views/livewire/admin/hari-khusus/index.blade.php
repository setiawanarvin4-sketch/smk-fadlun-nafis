<div>
    <h1 class="text-xl font-semibold text-navy mb-1">Hari Khusus (Pulang Cepat)</h1>
    <p class="text-sm text-[#667085] mb-4 max-w-2xl">
        Pakai ini kalau suatu hari sekolah pulang lebih awal dari jadwal biasa — rapat mendadak, acara,
        atau kejadian lain yang baru diputuskan hari itu juga. Boleh diisi untuk <b>hari ini</b> sekalipun,
        langsung berlaku begitu disimpan. Semua jam pelajaran yang seharusnya mulai <b>setelah</b> jam pulang
        yang diisi otomatis tidak akan dianggap "belum absen" oleh guru dan tidak akan dikirimi pengingat WhatsApp.
    </p>

    <form wire:submit="simpan" class="bg-white border border-[#E5E7EB] rounded-lg p-5 space-y-4 max-w-xl mb-8">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-sm text-[#667085]">Tanggal</label>
                <input type="date" wire:model="tanggal" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="text-sm text-[#667085]">Jam Pulang</label>
                <input type="time" wire:model="jam_pulang" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
                @error('jam_pulang') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            <label class="text-sm text-[#667085]">Keterangan (opsional)</label>
            <input type="text" wire:model="keterangan" placeholder="Contoh: Rapat wali murid mendadak" class="w-full border border-[#E5E7EB] rounded px-3 py-2 mt-1">
        </div>
        <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-lg text-sm font-semibold">Simpan</button>
    </form>

    <div class="bg-white border border-[#E5E7EB] rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#F6F7FA] text-left">
                <tr>
                    <th class="p-3.5 font-semibold text-[#667085]">Tanggal</th>
                    <th class="p-3.5 font-semibold text-[#667085]">Jam Pulang</th>
                    <th class="p-3.5 font-semibold text-[#667085]">Keterangan</th>
                    <th class="p-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E7EB]">
                @forelse($daftar as $item)
                    <tr>
                        <td class="p-3.5">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="p-3.5">{{ substr($item->jam_pulang, 0, 5) }}</td>
                        <td class="p-3.5 text-[#667085]">{{ $item->keterangan ?: '-' }}</td>
                        <td class="p-3.5 text-right">
                            <button wire:click="hapus({{ $item->id }})" wire:confirm="Hapus hari khusus ini? Jadwal di tanggal itu akan dianggap normal lagi." class="text-red-500 text-xs font-medium">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-[#667085]">Belum ada hari khusus yang dicatat.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3.5">{{ $daftar->links() }}</div>
    </div>
</div>