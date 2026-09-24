<div class="max-w-[1100px] mx-auto px-4 py-14">
    <p class="h-eyebrow">Galeri</p>
    <h1 class="h-section mb-2">Siswa Berprestasi</h1>
    <p class="text-[#667085] mb-6">Daftar siswa yang pernah meraih prestasi di SMK Fadlun Nafis Bangsri.</p>

    <div class="flex flex-wrap gap-3 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama..."
            class="border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue">
        <select wire:model.live="filterKelas" class="border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterKompetensi" class="border border-[#E5E7EB] rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Kompetensi</option>
            @foreach($kompetensiList as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white border border-[#E5E7EB] rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#F6F7FA] text-left text-[#667085]">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Kelas</th>
                        <th class="p-3">Kompetensi</th>
                        <th class="p-3">Prestasi Terbaru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $item)
                        <tr class="border-t border-[#E5E7EB] hover:bg-[#F6F7FA] transition-colors">
                            <td class="p-3">{{ $items->firstItem() + $i }}</td>
                            <td class="p-3">
                                <a href="{{ route('public.siswa.show', $item->id) }}" class="text-accent-blue font-medium hover:underline">{{ $item->nama }}</a>
                            </td>
                            <td class="p-3">{{ $item->kelas->nama_kelas ?? '-' }}</td>
                            <td class="p-3">{{ $item->kompetensi->nama ?? '-' }}</td>
                            <td class="p-3 text-[#667085]">{{ $item->prestasi->first()?->judul ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
</div>