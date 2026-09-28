<div class="max-w-[1280px] mx-auto px-4 py-14">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($items as $item)
            <a href="{{ route('public.agenda.show', $item->id) }}" class="group bg-white border border-[#E5E7EB] rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <div class="relative h-40">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->judul }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-light-blue"></div>
                    @endif
                    <div class="absolute top-3 left-3 bg-white rounded-lg px-3 py-1.5 text-center shadow-md leading-none">
                        <p class="text-[10px] font-bold text-accent-blue uppercase tracking-wide">{{ $item->tanggal->translatedFormat('M') }}</p>
                        <p class="text-lg font-bold text-navy mt-0.5">{{ $item->tanggal->format('d') }}</p>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-navy mb-2 line-clamp-2 group-hover:text-accent-blue transition-colors">{{ $item->judul }}</h3>
                    <p class="text-xs text-[#667085] flex items-center gap-1.5 flex-wrap">
                        @if($item->jam)
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ substr($item->jam, 0, 5) }}
                        @endif
                        @if($item->lokasi)
                            <span>&middot; {{ $item->lokasi }}</span>
                        @endif
                    </p>
                    @if($item->deskripsi)
                        <p class="text-sm text-[#667085] mt-2 line-clamp-2">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </a>
        @empty
            <div class="bg-white border border-[#E5E7EB] rounded-xl col-span-full text-center py-14 text-[#667085]">
                Belum ada agenda.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
</div>