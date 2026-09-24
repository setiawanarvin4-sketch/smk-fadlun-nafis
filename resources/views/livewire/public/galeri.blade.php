<div class="max-w-[1280px] mx-auto px-4 py-14" x-data="{ lightbox: null }">
    <div class="flex flex-wrap gap-2 mb-8">
        <button wire:click="$set('filterKategori', '')" class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ !$filterKategori ? 'bg-navy text-white' : 'bg-white border border-[#E5E7EB] hover:border-accent-blue' }}">Semua</button>
        @foreach(['Kegiatan Sekolah', 'Pembelajaran', 'APHP', 'Farmasi', 'Prestasi', 'Event'] as $kat)
            <button wire:click="$set('filterKategori', '{{ $kat }}')" class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors {{ $filterKategori === $kat ? 'bg-navy text-white' : 'bg-white border border-[#E5E7EB] hover:border-accent-blue' }}">{{ $kat }}</button>
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @forelse($items as $item)
            <button type="button" @click="lightbox = '{{ asset('storage/'.$item->file) }}|{{ addslashes($item->judul) }}'" class="group text-left card-premium overflow-hidden flex flex-col">
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/'.$item->file) }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <p class="text-sm font-bold text-navy leading-snug group-hover:text-accent-blue transition-colors">{{ $item->judul }}</p>
                    @if($item->deskripsi)
                        <p class="text-xs text-[#667085] mt-1.5 line-clamp-2">{{ $item->deskripsi }}</p>
                    @endif
                    <div class="mt-auto pt-3 flex items-center justify-between">
                        @if($item->kategori)
                            <span class="px-2.5 py-1 rounded-full bg-light-blue text-accent-blue text-[10px] font-bold uppercase tracking-wide">{{ $item->kategori }}</span>
                        @else
                            <span></span>
                        @endif
                        <span class="text-[10px] text-[#667085]">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </button>
        @empty
            <div class="card-premium col-span-4 text-center py-14 text-[#667085] hover:-translate-y-0">
                Belum ada galeri.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->links() }}</div>

    <!-- LIGHTBOX -->
    <div x-show="lightbox" x-cloak @click="lightbox = null" @keydown.escape.window="lightbox = null"
         class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 flex items-center justify-center p-4 md:p-10"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <button @click="lightbox = null" class="absolute top-5 right-5 md:top-8 md:right-8 text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm w-11 h-11 rounded-full flex items-center justify-center transition-colors z-10">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div @click.stop
             x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="bg-white/5 backdrop-blur-sm rounded-2xl p-2 md:p-3 shadow-2xl ring-1 ring-white/10 max-w-3xl w-full">
            <img :src="lightbox ? lightbox.split('|')[0] : ''" class="w-full max-h-[70vh] object-contain rounded-xl">
            <p class="text-white/80 text-center text-sm mt-3 pb-1" x-text="lightbox ? lightbox.split('|')[1] : ''"></p>
        </div>
    </div>
</div>