<x-layouts.public :title="$agenda->judul" :description="$agenda->deskripsi ? Str::limit(strip_tags($agenda->deskripsi), 150) : null" :image="$agenda->foto ? asset('storage/'.$agenda->foto) : null">
    <section class="relative bg-navy text-white overflow-hidden min-h-[48vh] flex items-end pt-28 pb-20">
        @if($agenda->foto)
            <img src="{{ asset('storage/'.$agenda->foto) }}" alt="{{ $agenda->judul }}" class="absolute inset-0 w-full h-full object-cover animate-hero-zoom">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-black/20"></div>

        <a href="{{ route('public.agenda') }}" aria-label="Kembali ke Agenda"
           class="absolute top-24 left-4 md:left-8 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 border border-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>

        <div class="relative max-w-[800px] mx-auto px-4 text-center w-full" style="text-shadow: 0 1px 3px rgba(0,0,0,0.9), 0 2px 10px rgba(0,0,0,0.7), 0 4px 24px rgba(0,0,0,0.45)">
            <p class="text-xs font-bold tracking-[0.18em] uppercase text-white">Agenda Sekolah &middot; {{ $agenda->tanggal->translatedFormat('d F Y') }}</p>
            <h1 class="h-hero text-white mt-2">{{ $agenda->judul }}</h1>
            <div class="w-14 h-1 bg-emerald-500 rounded-full mx-auto mt-5"></div>
        </div>
    </section>

    <div class="max-w-[800px] mx-auto px-4">
        <nav class="text-xs pt-6 flex items-center gap-1.5 flex-wrap">
            <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
            <span class="text-[#C7CBD1]">/</span>
            <a href="{{ route('public.agenda') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Agenda</a>
            <span class="text-[#C7CBD1]">/</span>
            <span class="text-[#667085] line-clamp-1">{{ $agenda->judul }}</span>
        </nav>

        {{-- KARTU RINGKASAN --}}
        <div class="relative -mt-14 mb-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-[#EDEEF0] p-6 flex flex-wrap gap-6 justify-around text-center">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-navy">{{ $agenda->tanggal->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-[#667085]">Tanggal</p>
                </div>
                @if($agenda->jam)
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-navy">{{ substr($agenda->jam, 0, 5) }} WIB</p>
                        <p class="text-xs text-[#667085]">Waktu</p>
                    </div>
                @endif
                @if($agenda->lokasi)
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke="currentColor" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-navy">{{ $agenda->lokasi }}</p>
                        <p class="text-xs text-[#667085]">Lokasi</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="py-10 space-y-8">
            @if($agenda->deskripsi)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <p class="h-eyebrow">Detail</p>
                    <h2 class="h-sub mb-4">Tentang Agenda Ini</h2>
                    <div class="prose prose-sm max-w-none text-navy">{{ $agenda->deskripsi }}</div>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3 pb-14">
            <span class="text-sm font-medium text-[#667085]">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($agenda->judul.' - '.url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-green-50 hover:bg-green-100 flex items-center justify-center text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-accent-blue transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
            </a>
        </div>
    </div>
</x-layouts.public>