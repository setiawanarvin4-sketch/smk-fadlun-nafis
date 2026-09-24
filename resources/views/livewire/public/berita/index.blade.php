<div class="max-w-[1280px] mx-auto px-4 py-14">
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari berita..."
        class="border border-[#E5E7EB] rounded-lg px-4 py-2.5 text-sm mb-8 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($items as $item)
            <a href="{{ route('public.berita.show', $item->slug) }}" class="group bg-white border border-[#E5E7EB] rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <img src="{{ asset('storage/'.$item->thumbnail) }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <span class="text-xs text-accent-blue font-medium">{{ $item->kategori }}</span>
                    <h3 class="font-semibold text-navy mt-1 mb-2 line-clamp-2 group-hover:text-accent-blue transition-colors">{{ $item->judul }}</h3>
                    <p class="text-sm text-[#667085] line-clamp-2">{{ $item->ringkasan }}</p>
                    <p class="text-xs text-[#667085] mt-3">{{ $item->tanggal_publikasi?->translatedFormat('d F Y') }}</p>
                </div>
            </a>
        @empty
            <div class="bg-white border border-[#E5E7EB] rounded-xl col-span-3 text-center py-14 text-[#667085]">
                Belum ada berita.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
</div>