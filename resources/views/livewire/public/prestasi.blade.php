<div class="max-w-[1280px] mx-auto px-4 py-14">
    <div class="flex gap-2 mb-8">
        <button wire:click="$set('filterKategori', '')" class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ !$filterKategori ? 'bg-navy text-white' : 'bg-white border border-[#E5E7EB] hover:border-accent-blue' }}">Semua</button>
        <button wire:click="$set('filterKategori', 'Akademik')" class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ $filterKategori === 'Akademik' ? 'bg-navy text-white' : 'bg-white border border-[#E5E7EB] hover:border-accent-blue' }}">Akademik</button>
        <button wire:click="$set('filterKategori', 'Non-Akademik')" class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ $filterKategori === 'Non-Akademik' ? 'bg-navy text-white' : 'bg-white border border-[#E5E7EB] hover:border-accent-blue' }}">Non-Akademik</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($items as $item)
            <a href="{{ route('public.prestasi.show', $item->id) }}" class="group card-premium overflow-hidden">
                <div class="overflow-hidden">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}" class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-36 bg-light-blue flex items-center justify-center text-accent-blue text-sm font-semibold">{{ $item->kategori }}</div>
                    @endif
                </div>
                <div class="p-4">
                    <span class="text-xs text-accent-blue font-medium">{{ $item->kategori }} &middot; {{ $item->tingkat }}</span>
                    <h3 class="font-semibold text-navy mt-1 group-hover:text-accent-blue transition-colors">{{ $item->judul }}</h3>
                    <p class="text-sm text-[#667085] mt-1">{{ $item->siswa->nama ?? 'Sekolah' }} &middot; {{ $item->tahun }}</p>
                </div>
            </a>
        @empty
            <div class="card-premium col-span-3 text-center py-14 text-[#667085] hover:-translate-y-0">
                Belum ada prestasi.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
</div>