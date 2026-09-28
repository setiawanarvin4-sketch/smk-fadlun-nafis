<x-layouts.public :title="$item->judul" :description="$item->deskripsi ? Str::limit(strip_tags($item->deskripsi), 150) : null" :image="$item->foto ? asset('storage/'.$item->foto) : null">
    <section class="relative bg-navy text-white overflow-hidden min-h-[48vh] flex items-end pt-28 pb-20">
        @if($item->foto)
            <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->judul }}" class="absolute inset-0 w-full h-full object-cover opacity-100 animate-hero-zoom">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-black/20"></div>

        <a href="{{ route('public.prestasi') }}" aria-label="Kembali ke Prestasi"
           class="absolute top-24 left-4 md:left-8 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 border border-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>

        <div class="relative max-w-[800px] mx-auto px-4 text-center w-full" style="text-shadow: 0 1px 3px rgba(0,0,0,0.9), 0 2px 10px rgba(0,0,0,0.7), 0 4px 24px rgba(0,0,0,0.45)">
            <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white justify-center">{{ $item->kategori }} &middot; {{ $item->tingkat }}</p>
            <h1 class="h-hero text-white mt-2">{{ $item->judul }}</h1>
            @if($item->penulis)
                <p class="text-xs text-white/70 mt-1">Dipublikasikan oleh {{ $item->penulis->nama_tampilan }}</p>            @endif
            <div class="w-14 h-1 bg-emerald-500 rounded-full mx-auto mt-5"></div>
        </div>
    </section>

    <div class="max-w-[800px] mx-auto px-4">
        <nav class="text-xs pt-6 flex items-center gap-1.5 flex-wrap">
            <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
            <span class="text-[#C7CBD1]">/</span>
            <a href="{{ route('public.prestasi') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Prestasi</a>
            <span class="text-[#C7CBD1]">/</span>
            <span class="text-[#667085] line-clamp-1">{{ $item->judul }}</span>
        </nav>

        <div class="relative -mt-14 mb-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-[#EDEEF0] p-6 flex flex-wrap gap-6 justify-around text-center">
                <div>
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2-8 4.5V21h16v-2.5c0-2.5-3.6-4.5-8-4.5z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-navy">{{ $item->siswa->nama ?? 'Sekolah' }}</p>
                    <p class="text-xs text-[#667085]">Atas Nama</p>
                </div>
                <div>
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-navy">{{ $item->tahun }}</p>
                    <p class="text-xs text-[#667085]">Tahun</p>
                </div>
                @if($item->kompetensi)
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.02 12.02 0 0112 21a12.02 12.02 0 01-6.16-10.42L12 14z"/></svg>
                        </div>
                        <p class="text-sm font-bold text-navy">{{ $item->kompetensi->nama }}</p>
                        <p class="text-xs text-[#667085]">Kompetensi</p>
                    </div>
                @endif
                @if($item->penyelenggara)
                    <div>
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m8-16h.01M11 9h.01M11 13h.01M11 17h.01M7 9h.01M7 13h.01M7 17h.01M15 9h.01M15 13h.01M15 17h.01"/></svg>
                        </div>
                        <p class="text-sm font-bold text-navy">{{ $item->penyelenggara }}</p>
                        <p class="text-xs text-[#667085]">Penyelenggara</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="py-10 space-y-8">
            @if($item->deskripsi)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <p class="h-eyebrow">Detail</p>
                    <h2 class="h-sub mb-4">Cerita di Balik Prestasi Ini</h2>
                    <p class="h-body">{{ $item->deskripsi }}</p>
                </div>
            @endif

            @if($item->foto_sertifikat || $item->foto_dokumentasi)
                <div>
                    <p class="h-eyebrow">Bukti & Dokumentasi</p>
                    <h2 class="h-sub mb-5">Sertifikat & Foto Kegiatan</h2>
                    <div class="grid {{ $item->foto_sertifikat && $item->foto_dokumentasi ? 'md:grid-cols-2' : '' }} gap-5">
                        @if($item->foto_sertifikat)
                            <a href="{{ asset('storage/'.$item->foto_sertifikat) }}" target="_blank" class="group block rounded-2xl overflow-hidden border border-[#EDEEF0] hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/'.$item->foto_sertifikat) }}" alt="Sertifikat {{ $item->judul }}" loading="lazy" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-500">
                                <p class="text-xs text-[#667085] p-3 border-t border-[#EDEEF0]">Sertifikat / Piagam</p>
                            </a>
                        @endif
                        @if($item->foto_dokumentasi)
                            <a href="{{ asset('storage/'.$item->foto_dokumentasi) }}" target="_blank" class="group block rounded-2xl overflow-hidden border border-[#EDEEF0] hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/'.$item->foto_dokumentasi) }}" alt="Dokumentasi {{ $item->judul }}" loading="lazy" class="w-full aspect-[4/3] object-cover group-hover:scale-105 transition-transform duration-500">
                                <p class="text-xs text-[#667085] p-3 border-t border-[#EDEEF0]">Dokumentasi Kegiatan</p>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        
        <div class="flex items-center gap-3 mb-6">
            <span class="text-sm font-medium text-[#667085]">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($item->judul.' - '.url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-green-50 hover:bg-green-100 flex items-center justify-center text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-accent-blue transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
            </a>
        </div>
        <!-- PRESTASI LAIN -->
        @php $lainnya = \App\Models\Prestasi::where('id', '!=', $item->id)->orderByDesc('tahun')->limit(3)->get(); @endphp
        @if($lainnya->count())
            <div class="pb-16">
                <p class="h-eyebrow">Jelajahi Lebih Lanjut</p>
                <h2 class="h-sub mb-5">Prestasi Lainnya</h2>
                <div class="grid md:grid-cols-3 gap-5">
                    @foreach($lainnya as $p)
                        <a href="{{ route('public.prestasi.show', $p->id) }}" class="group card-premium overflow-hidden">
                            <div class="overflow-hidden h-28">
                                @if($p->foto)
                                    <img src="{{ asset('storage/'.$p->foto) }}" alt="{{ $p->judul }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-light-blue"></div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="font-bold text-navy text-sm line-clamp-2 group-hover:text-accent-blue transition-colors">{{ $p->judul }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>