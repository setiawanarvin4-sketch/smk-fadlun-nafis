<div class="max-w-[800px] mx-auto px-4 py-14">
    <nav class="text-xs mb-4 flex items-center gap-1.5 flex-wrap" data-reveal>
        <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
        <span class="text-[#C7CBD1]">/</span>
        <a href="{{ route('public.berita') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Berita</a>
        <span class="text-[#C7CBD1]">/</span>
        <span class="text-[#667085] line-clamp-1">{{ $berita->judul }}</span>
    </nav>

    <a href="{{ route('public.berita') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy bg-[#F6F7FA] hover:bg-light-blue hover:text-accent-blue border border-[#E5E7EB] px-3.5 py-1.5 rounded-full mb-4 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Berita
    </a>

    <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mt-6 mb-2">{{ $berita->kategori }}</p>
    <h1 class="text-2xl md:text-3xl font-bold text-navy leading-tight">{{ $berita->judul }}</h1>
    <p class="text-sm text-[#667085] mt-3">
        Oleh {{ $berita->penulis->name ?? 'Admin' }} · {{ $berita->tanggal_publikasi?->translatedFormat('d F Y') }}
    </p>

    <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-full h-64 md:h-80 object-cover rounded-xl mt-6">

    <div class="prose prose-sm max-w-none mt-8 text-navy">
        {!! $berita->isi !!}
    </div>

    <div class="mt-8 pt-6 border-t border-[#E5E7EB] flex items-center gap-3">
        <span class="text-sm font-medium text-[#667085]">Bagikan:</span>
        <a href="https://wa.me/?text={{ urlencode($berita->judul.' - '.url()->current()) }}" target="_blank" rel="noopener"
           class="w-9 h-9 rounded-full bg-green-50 hover:bg-green-100 flex items-center justify-center text-green-600 transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
           class="w-9 h-9 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-accent-blue transition-colors">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
        </a>
    </div>

    @if($terkait->count())
        <div class="mt-14 border-t border-[#E5E7EB] pt-8">
            <p class="text-xs font-semibold tracking-widest uppercase text-accent-blue mb-4">Berita Lainnya</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($terkait as $t)
                    <a href="{{ route('public.berita.show', $t->slug) }}" class="group bg-white border border-[#E5E7EB] rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                        <img src="{{ asset('storage/'.$t->thumbnail) }}" class="w-full h-24 object-cover">
                        <p class="text-sm font-medium p-3 group-hover:text-accent-blue transition-colors">{{ $t->judul }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>