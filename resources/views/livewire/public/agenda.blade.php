<div class="max-w-[900px] mx-auto px-4 py-14">
    <div class="space-y-3">
        @forelse($items as $item)
            <a href="{{ route('public.agenda.show', $item->id) }}" class="group bg-white border border-[#E5E7EB] rounded-xl overflow-hidden flex hover:shadow-lg hover:-translate-y-0.5 transition-all">
                @if($item->foto)
                    <img src="{{ asset('storage/'.$item->foto) }}" class="w-32 h-full object-cover flex-shrink-0">
                @endif
                <div class="p-4 flex gap-4 flex-1">
                    <div class="bg-light-blue text-accent-blue rounded-lg w-16 h-16 flex flex-col items-center justify-center flex-shrink-0">
                        <span class="text-xs font-medium">{{ $item->tanggal->translatedFormat('M') }}</span>
                        <span class="text-xl font-bold">{{ $item->tanggal->format('d') }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-navy group-hover:text-accent-blue transition-colors">{{ $item->judul }}</p>
                        <p class="text-sm text-[#667085] mt-1">
                            {{ $item->jam ? substr($item->jam, 0, 5) : '' }}
                            @if($item->lokasi) · {{ $item->lokasi }} @endif
                        </p>
                        @if($item->deskripsi)
                            <p class="text-sm text-[#667085] mt-1 line-clamp-2">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white border border-[#E5E7EB] rounded-xl p-10 text-center text-[#667085]">
                Belum ada agenda.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>
</div>