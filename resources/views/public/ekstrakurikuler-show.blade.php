<x-layouts.public :title="$item->nama" :description="$item->deskripsi ? Str::limit(strip_tags($item->deskripsi), 150) : null" :image="$item->foto ? asset('storage/'.$item->foto) : null">
    <section class="relative bg-navy text-white overflow-hidden min-h-[62vh] flex items-end pb-20">
        @if($item->foto)
            <img src="{{ asset('storage/'.$item->foto) }}" class="absolute inset-0 w-full h-full object-cover opacity-100 animate-hero-zoom">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/15"></div>
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-black/75 via-black/35 to-transparent pointer-events-none"></div>
        <div class="absolute -top-16 -left-16 w-72 h-72 bg-accent-teal/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-blue/15 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>

        <div class="relative max-w-[800px] mx-auto px-4 text-center w-full">
            <a href="{{ route('public.ekstrakurikuler') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-white/80 hover:text-white bg-white/10 hover:bg-white/15 border border-white/15 px-3.5 py-1.5 rounded-full mb-8 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Ekstrakurikuler
            </a>
            <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white/90 justify-center">Kegiatan Siswa</p>
            <h1 class="h-hero text-white mt-2" style="text-shadow: 0 2px 20px rgba(0,0,0,0.35)">{{ $item->nama }}</h1>
            <div class="w-14 h-1 bg-emerald-500 rounded-full mx-auto mt-5"></div>
        </div>
    </section>

    <div class="max-w-[800px] mx-auto px-4">
        <nav class="text-xs pt-6 flex items-center gap-1.5 flex-wrap">
            <a href="{{ route('home') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Beranda</a>
            <span class="text-[#C7CBD1]">/</span>
            <a href="{{ route('public.ekstrakurikuler') }}" class="text-accent-blue font-medium hover:text-navy transition-colors">Ekstrakurikuler</a>
            <span class="text-[#C7CBD1]">/</span>
            <span class="text-[#667085] line-clamp-1">{{ $item->nama }}</span>
        </nav>

        @if($item->pembina)
            <div class="relative -mt-14 mb-4">
                <div class="bg-white rounded-2xl shadow-xl border border-[#EDEEF0] p-5 flex items-center gap-4 max-w-sm mx-auto">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.4 0-8 2-8 4.5V21h16v-2.5c0-2.5-3.6-4.5-8-4.5z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-[#667085] uppercase tracking-wide font-semibold">Pembina</p>
                        <p class="font-bold text-navy">{{ $item->pembina }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="py-10 space-y-8">
            @if($item->deskripsi)
                <div class="card-premium p-8 hover:-translate-y-0">
                    <p class="h-eyebrow">Tentang</p>
                    <h2 class="h-sub mb-4">Tentang Kegiatan Ini</h2>
                    <p class="h-body">{{ $item->deskripsi }}</p>
                </div>
            @endif

            @if($item->visi || $item->misi)
                <div class="grid md:grid-cols-2 gap-6">
                    @if($item->visi)
                        <div class="card-premium p-7 hover:-translate-y-0">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/><path stroke="currentColor" stroke-width="1.5" d="M12 15a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            </div>
                            <h3 class="h-sub mb-2">Visi</h3>
                            <p class="h-body">{{ $item->visi }}</p>
                        </div>
                    @endif
                    @if($item->misi)
                        <div class="card-premium p-7 hover:-translate-y-0">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a9.5 9.5 0 11-19 0 9.5 9.5 0 0119 0z"/></svg>
                            </div>
                            <h3 class="h-sub mb-2">Misi</h3>
                            <div class="h-body space-y-1.5">
                                @foreach(preg_split('/\r\n|\r|\n/', $item->misi) as $baris)
                                    @if(trim($baris))
                                        <div class="flex items-start gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-accent-blue mt-2 flex-shrink-0"></span>
                                            <span>{{ trim($baris, "- ") }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @php $fotoKegiatan = collect([$item->foto_kegiatan_1, $item->foto_kegiatan_2, $item->foto_kegiatan_3])->filter(); @endphp
            @if($fotoKegiatan->count())
                <div>
                    <p class="h-eyebrow">Dokumentasi</p>
                    <h2 class="h-sub mb-5">Momen Kegiatan</h2>
                    <div class="grid {{ $fotoKegiatan->count() >= 3 ? 'grid-cols-2 sm:grid-cols-3' : ($fotoKegiatan->count() === 2 ? 'grid-cols-2' : 'grid-cols-1 max-w-sm') }} gap-4">
                        @foreach($fotoKegiatan as $foto)
                            <a href="{{ asset('storage/'.$foto) }}" target="_blank" class="group relative rounded-2xl overflow-hidden aspect-[4/3] shadow-sm hover:shadow-lg transition-shadow block">
                                <img src="{{ asset('storage/'.$foto) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        
        <div class="flex items-center gap-3 mb-6">
            <span class="text-sm font-medium text-[#667085]">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($item->nama.' - '.url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-green-50 hover:bg-green-100 flex items-center justify-center text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener"
               class="w-9 h-9 rounded-full bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-accent-blue transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z"/></svg>
            </a>
        </div>
        <!-- EKSKUL LAIN -->
        @php $lainnya = \App\Models\Ekstrakurikuler::where('aktif', true)->where('id', '!=', $item->id)->limit(3)->get(); @endphp
        @if($lainnya->count())
            <div class="pb-16">
                <p class="h-eyebrow">Jelajahi Lebih Lanjut</p>
                <h2 class="h-sub mb-5">Ekstrakurikuler Lainnya</h2>
                <div class="grid md:grid-cols-3 gap-5">
                    @foreach($lainnya as $e)
                        <a href="{{ route('public.ekstrakurikuler.show', $e->id) }}" class="group card-premium overflow-hidden">
                            <div class="overflow-hidden h-28">
                                @if($e->foto)
                                    <img src="{{ asset('storage/'.$e->foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-accent-blue to-accent-teal flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr($e->nama, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="font-bold text-navy text-sm group-hover:text-accent-blue transition-colors">{{ $e->nama }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.public>