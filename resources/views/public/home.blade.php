<x-layouts.public>
    <!-- POPUP PENGUMUMAN (dikelola dari Admin > Pengumuman Beranda; hanya di homepage, muncul tiap refresh kecuali user pilih "jangan tampilkan lagi") -->
    @if($pengumuman)
        <div x-data="{ open: false, jangan: false }"
             x-init="if (!localStorage.getItem('popup_pengumuman_{{ $pengumuman->id }}_hide')) { setTimeout(() => open = true, 600) }"
             x-show="open" x-cloak
             @keydown.escape.window="open = false"
             class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-navy/70 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div @click.outside="open = false; if (jangan) localStorage.setItem('popup_pengumuman_{{ $pengumuman->id }}_hide', '1')"
                 x-show="open" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden">
                <button @click="open = false; if (jangan) localStorage.setItem('popup_pengumuman_{{ $pengumuman->id }}_hide', '1')" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-navy flex items-center justify-center shadow-md transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <div class="relative h-40 bg-navy">
                    @if($pengumuman->gambar)
                        <img src="{{ asset('storage/'.$pengumuman->gambar) }}" class="absolute inset-0 w-full h-full object-cover">
                    @elseif($sambutan->foto)
                        <img src="{{ asset('storage/'.$sambutan->foto) }}" class="absolute inset-0 w-full h-full object-cover object-top">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/50 to-navy/10"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5">
                        @if($pengumuman->label_atas)
                            <p class="text-emerald-400 text-xs font-bold uppercase tracking-widest mb-1">{{ $pengumuman->label_atas }}</p>
                        @endif
                        <p class="text-white font-extrabold text-lg leading-tight">{{ $pengumuman->judul }}</p>
                    </div>
                </div>

                <div class="p-6">
                    @if($pengumuman->deskripsi)
                        <p class="text-[#667085] text-sm leading-relaxed mb-4">{{ $pengumuman->deskripsi }}</p>
                    @endif
                    <label class="flex items-center gap-2 text-xs text-[#667085] mb-5 cursor-pointer select-none">
                        <input type="checkbox" x-model="jangan" class="rounded border-[#E5E7EB]">
                        Jangan tampilkan pengumuman ini lagi
                    </label>
                    <div class="flex gap-3">
                        @if($pengumuman->button_text && $pengumuman->button_url)
                            <a href="{{ $pengumuman->button_url }}" class="flex-1 text-center bg-navy text-white px-5 py-3 rounded-lg font-bold text-sm hover:bg-accent-blue transition-colors">{{ $pengumuman->button_text }}</a>
                        @endif
                        <button @click="open = false; if (jangan) localStorage.setItem('popup_pengumuman_{{ $pengumuman->id }}_hide', '1')" class="flex-1 px-5 py-3 rounded-lg font-bold text-sm text-navy border border-[#E5E7EB] hover:border-navy/30 transition-colors">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- HERO -->
    @if($heroSliders->count())
        <section class="relative bg-navy text-white min-h-[80svh] flex items-end"
                 x-data="{ active: 0, total: {{ $heroSliders->count() }} }"
                 x-init="setInterval(() => { active = (active + 1) % total }, 6000)">

            <div class="absolute inset-0 overflow-hidden">
                @foreach($heroSliders as $i => $hero)
                    <div x-show="active === {{ $i }}" x-cloak
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="absolute inset-0">
                        <img src="{{ asset('storage/'.$hero->foto) }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
                    </div>
                @endforeach
                <!-- Lapisan gelap statis di atas foto, khusus area navbar — selalu ada,
                     tidak tergantung status scroll/JavaScript, supaya logo & menu selalu
                     kebaca walau foto slide-nya terang. -->
                <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-black/75 via-black/35 to-transparent pointer-events-none"></div>
            </div>

            <div class="absolute top-8 left-4 right-4 md:top-10 md:left-10 md:right-10 z-10 flex justify-between items-start pointer-events-none">
                <div class="w-10 h-10 border-t-2 border-l-2 border-white/30"></div>
                <div class="w-10 h-10 border-t-2 border-r-2 border-white/30"></div>
            </div>

            @foreach($heroSliders as $i => $hero)
                <div x-show="active === {{ $i }}" x-cloak
                     x-transition:enter="transition ease-out duration-700 delay-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="relative z-10 w-full">
                    <div class="max-w-[1280px] w-full mx-auto px-4 md:px-10 pb-28 pt-32">
                        <div class="max-w-2xl">
                            @if($hero->badge)
                                <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white/90 border-l-2 border-emerald-500 pl-3 mb-6">
                                    {{ $hero->badge }}
                                </p>
                            @endif
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.08] mb-5">{{ $hero->judul }}</h1>
                            <p class="text-white/75 text-base md:text-lg max-w-lg mb-9 leading-relaxed">{{ $hero->deskripsi }}</p>
                            <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                                @if($hero->button1_text && $hero->button1_url)
                                    <a href="{{ $hero->button1_url }}" class="group bg-white text-navy px-7 py-3.5 rounded-lg font-bold text-sm hover:bg-accent-blue hover:text-white transition-all duration-300 inline-flex items-center gap-2 shadow-xl">
                                        {{ $hero->button1_text }}
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                    </a>
                                @endif
                                @if($hero->button2_text && $hero->button2_url)
                                    <a href="{{ $hero->button2_url }}" class="group text-white font-semibold text-sm inline-flex items-center gap-2 border-b border-white/40 pb-1 hover:border-white transition-colors">
                                        {{ $hero->button2_text }}
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                    </a>
                                @endif
                                @if(!$hero->button1_text && !$hero->button2_text)
                                    <a href="{{ route('public.ppdb') }}" class="group bg-white text-navy px-7 py-3.5 rounded-lg font-bold text-sm hover:bg-accent-blue hover:text-white transition-all duration-300 inline-flex items-center gap-2 shadow-xl">
                                        Info PPDB
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="absolute right-6 md:right-10 bottom-10 z-20 hidden lg:flex items-center gap-3 text-white/50">
                <span class="text-[10px] uppercase tracking-widest">Scroll</span>
                <span class="w-px h-8 bg-white/30"></span>
            </div>

            @if($heroSliders->count() > 1)
                <button @click="active = (active - 1 + total) % total" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button @click="active = (active + 1) % total" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
                </button>
                <div class="absolute bottom-10 left-1/2 -translate-x-1/2 lg:left-auto lg:translate-x-0 lg:right-10 z-20 flex gap-2">
                    @foreach($heroSliders as $i => $hero)
                        <button @click="active = {{ $i }}" class="h-1.5 rounded-full transition-all" :class="active === {{ $i }} ? 'bg-emerald-500 w-8' : 'bg-white/30 w-4'"></button>
                    @endforeach
                </div>
            @endif

        </section>
    @else
        <section class="relative bg-gradient-to-br from-navy to-navy-dark text-white overflow-hidden min-h-[80svh] flex items-end">
            <div class="relative max-w-[1280px] w-full mx-auto px-4 pb-24 pt-32">
                <div class="max-w-2xl">
                    <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white/90 border-l-2 border-emerald-500 pl-3 mb-6">SMK Fadlun Nafis Bangsri</p>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.08] mb-5">Membentuk Generasi Berakhlak Mulia &amp; Siap Kerja</h1>
                    <p class="text-white/75 text-base md:text-lg max-w-lg mb-9 leading-relaxed">Belajar, Berkarya, dan Berprestasi bersama SMK Fadlun Nafis Bangsri.</p>
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                        <a href="{{ route('public.ppdb') }}" class="group bg-white text-navy px-7 py-3.5 rounded-lg font-bold text-sm hover:bg-accent-blue hover:text-white transition-all duration-300 inline-flex items-center gap-2 shadow-xl">
                            Info PPDB
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                        </a>
                        <a href="{{ route('public.profil') }}" class="group text-white font-semibold text-sm inline-flex items-center gap-2 border-b border-white/40 pb-1 hover:border-white transition-colors">
                            Profil Sekolah
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

        <!-- SAMBUTAN KEPSEK -->
    @if($sambutan->isi)
        <section class="max-w-[1280px] mx-auto px-4 py-24">
            <div class="grid md:grid-cols-[0.85fr_1.15fr] gap-16 items-center">
                <div class="relative max-w-sm mx-auto md:mx-0 mb-8">
                    <div class="absolute -top-4 -left-4 w-full h-full border-2 border-accent-gold/50 rounded-2xl -z-10"></div>
                    @if($sambutan->foto)
                        <img src="{{ asset('storage/'.$sambutan->foto) }}" class="w-full aspect-[3/4] object-cover rounded-2xl shadow-2xl">
                    @else
                        <div class="w-full aspect-[3/4] rounded-2xl bg-navy text-white flex items-center justify-center text-6xl font-bold shadow-2xl">
                            {{ substr($sambutan->nama ?? 'K', 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute left-6 -bottom-6 right-6 bg-white rounded-xl shadow-xl border border-[#EDEEF0] px-5 py-4">
                        <p class="font-bold text-navy leading-tight">{{ $sambutan->nama ?? 'Kepala Sekolah' }}</p>
                        <p class="text-xs text-[#667085] mt-0.5">{{ $sambutan->jabatan }}</p>
                    </div>
                </div>
                <div>
                    <p class="h-eyebrow">Selayang Pandang</p>
                    <h2 class="h-section mb-6">{{ $sambutan->judul ?? 'Sambutan Kepala Sekolah' }}</h2>
                    <svg class="w-10 h-10 text-accent-gold/50 mb-2" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 4C6 4 3 7.5 3 12.5c0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5S10 12 8.5 12c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L11 4.5C10.5 4.2 10 4 9.5 4zm10 0c-3.5 0-6.5 3.5-6.5 8.5 0 3.6 2.2 6 5 6 2 0 3.5-1.5 3.5-3.5s-1.5-3-3-3c-.4 0-.7 0-1 .1.3-2.4 2-4.5 4.5-5.3L21 4.5c-.5-.3-1-.5-1.5-.5z"/></svg>
                    <div class="prose prose-sm md:prose-base max-w-none h-body">{!! $sambutan->isi !!}</div>
                </div>
            </div>
        </section>
    @endif

        <!-- POSTINGAN TERBARU -->
    @if($beritaTerbaru->count())
        <section class="max-w-[1280px] mx-auto px-4 py-12">
            <div class="text-center mb-10">
                <h2 class="h-section">Postingan Terbaru</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($beritaTerbaru as $b)
                    <a href="{{ route('public.berita.show', $b->slug) }}" class="group bg-white border border-[#EDEEF0] rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/'.$b->thumbnail) }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($b->kategori)
                                <span class="absolute top-3 left-3 bg-white text-emerald-600 text-[11px] font-bold uppercase tracking-wide px-3 py-1.5 rounded-full shadow-sm">{{ $b->kategori }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-navy leading-snug line-clamp-2 group-hover:text-emerald-600 transition-colors">{{ $b->judul }}</h3>
                            <div class="flex items-center gap-4 mt-4 pt-4 border-t border-[#EDEEF0] text-xs text-[#667085]">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $b->penulis->name ?? 'Admin' }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $b->tanggal_publikasi->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('public.berita') }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-7 py-3.5 rounded-lg hover:bg-accent-blue transition-colors">Lihat Selengkapnya</a>
            </div>
        </section>
    @endif

    <!-- STATISTIK (dihitung otomatis dari data asli, bukan input manual) -->
    <section class="relative bg-gradient-to-br from-navy to-navy-dark overflow-hidden texture-rows">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent-teal/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent-blue/10 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>
        <div class="relative max-w-[1280px] mx-auto px-4 py-12">
            <div class="text-center mb-14">
                <h2 class="h-section text-white mb-3">Pencapaian Sekolah</h2>
                <p class="text-white/60 max-w-lg mx-auto">Angka yang mencerminkan kualitas SMK Fadlun Nafis Bangsri</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $ikonStatistik = [
                        '<path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.02 12.02 0 0121 12c0 2.5-.9 4.79-2.4 6.56M12 14L5.84 10.58A12.02 12.02 0 003 12c0 2.5.9 4.79 2.4 6.56M12 14v7"/>',
                        '<path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-3.13a4 4 0 100-8 4 4 0 000 8zm6 0a4 4 0 10-3.13-6.5m-9.74 0A4 4 0 106 12"/>',
                        '<path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6.04A8.97 8.97 0 006 3.75c-1.05 0-2.06.18-3 .512v14.25A8.99 8.99 0 016 18c2.3 0 4.41.87 6 2.29m0-14.25a8.97 8.97 0 016-2.29c1.05 0 2.06.18 3 .512v14.25A8.99 8.99 0 0018 18a8.97 8.97 0 00-6 2.29m0-14.25v14.25"/>',
                        '<path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"/>',
                    ];
                @endphp
                @foreach($statistikAsli as $s)
                    <div class="group relative border border-white/15 bg-white/[0.03] rounded-2xl p-7 text-center hover:bg-white/[0.06] hover:border-accent-teal/40 transition-all duration-300">
                        <div class="w-11 h-11 rounded-xl bg-white/10 group-hover:bg-accent-teal/20 flex items-center justify-center mx-auto mb-5 transition-colors duration-300">
                            <svg class="w-5 h-5 text-accent-teal" fill="none" viewBox="0 0 24 24">{!! $ikonStatistik[$loop->index] ?? '' !!}</svg>
                        </div>
                        <p class="text-4xl md:text-5xl font-extrabold text-white tracking-tight" data-counter="{{ $s['nilai'] }}">0</p>
                        <div class="w-8 h-0.5 bg-emerald-500 mx-auto my-4"></div>
                        <p class="text-sm text-white/60">{{ $s['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- KOMPETENSI KEAHLIAN -->
    <section class="max-w-[1280px] mx-auto px-4 py-12">
        <h2 class="h-section mb-8 text-center">Kompetensi Keahlian</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($kompetensiList as $k)
                <a href="{{ route('public.akademik.show', $k->slug) }}" class="group border border-[#EDEEF0] rounded-2xl p-7 flex gap-6 items-start hover:border-accent-blue/30 hover:shadow-lg transition-all duration-300">
                    @if($k->foto)
                        <img src="{{ asset('storage/'.$k->foto) }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-navy text-white flex items-center justify-center flex-shrink-0 font-bold text-xl">
                            {{ substr($k->nama, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="h-sub mb-2 group-hover:text-accent-blue transition-colors">{{ $k->nama }}</h3>
                        <p class="text-sm h-body line-clamp-2">{{ $k->deskripsi }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- EKSTRAKURIKULER -->
    @if($ekstrakurikulerList->count())
        <section class="py-12 overflow-hidden">
            <div class="max-w-[1280px] mx-auto px-4 text-center mb-10">
                <h2 class="h-section">Ekstrakurikuler</h2>
            </div>

            <div class="max-w-[1280px] mx-auto px-4">
                <div class="flex gap-5 overflow-x-auto pb-5 -mx-4 px-4 snap-x scroll-thin-green">
                    @foreach($ekstrakurikulerList as $e)
                        <a href="{{ route('public.ekstrakurikuler.show', $e->id) }}" class="group flex-shrink-0 w-40 bg-white border border-[#EDEEF0] rounded-2xl p-5 text-center hover:border-emerald-500/40 hover:shadow-lg transition-all duration-300 snap-start">
                            @if($e->foto)
                                <img src="{{ asset('storage/'.$e->foto) }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 ring-4 ring-[#F4FBF7] group-hover:ring-emerald-500/15 transition-all">
                            @else
                                <div class="w-20 h-20 rounded-full bg-navy text-white flex items-center justify-center mx-auto mb-4 text-2xl font-bold ring-4 ring-[#F4FBF7]">
                                    {{ substr($e->nama, 0, 1) }}
                                </div>
                            @endif
                            <p class="font-bold text-navy text-sm leading-snug group-hover:text-emerald-600 transition-colors">{{ $e->nama }}</p>
                            @if($e->pembina)
                                <p class="text-xs text-[#667085] mt-1.5 line-clamp-1">{{ $e->pembina }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('public.ekstrakurikuler') }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-7 py-3.5 rounded-lg hover:bg-accent-blue transition-colors">Lihat Selengkapnya</a>
                </div>
            </div>
        </section>
    @endif

    <!-- PRESTASI -->
    @if($prestasiTerbaru->count())
        <section class="py-12 overflow-hidden">
            <div class="max-w-[1280px] mx-auto px-4 text-center mb-10">
                <h2 class="h-section">Prestasi</h2>
            </div>
            <div class="max-w-[1280px] mx-auto px-4">
                <div class="scroll-thin-green overflow-x-auto pb-2 -mx-4 px-4">
                    <div class="flex gap-6 w-max">
                        @foreach($prestasiTerbaru as $p)
                            <a href="{{ route('public.prestasi.show', $p->id) }}" class="group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-shadow duration-300 w-60 aspect-[3/4] flex-shrink-0">
                                @if($p->foto)
                                    <img src="{{ asset('storage/'.$p->foto) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="absolute inset-0 bg-navy flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white/20" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.2" d="M12 15a5 5 0 100-10 5 5 0 000 10zM8.5 14L7 21l5-3 5 3-1.5-7"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/10 to-transparent"></div>
                                <div class="absolute top-3 left-3 bg-emerald-500 text-navy text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-md">{{ $p->tahun }}</div>
                                <p class="absolute inset-x-0 bottom-0 p-4 text-sm font-bold text-white line-clamp-2 leading-snug">{{ $p->judul }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('public.prestasi') }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-7 py-3.5 rounded-lg hover:bg-accent-blue transition-colors">Lihat Selengkapnya</a>
                </div>
            </div>
        </section>
    @endif

    <!-- SISWA BERPRESTASI -->
    @if($siswaBerprestasi->count())
        <section class="py-12 overflow-hidden">
            <div class="max-w-[1280px] mx-auto px-4 text-center mb-8">
                <h2 class="h-section">Siswa Berprestasi</h2>
            </div>
            <div class="max-w-[1280px] mx-auto px-4">
                <div class="scroll-thin-green overflow-x-auto pb-2 -mx-4 px-4">
                    <div class="flex gap-6 w-max">
                        @foreach($siswaBerprestasi as $p)
                            @if($p->siswa)
                                <a href="{{ route('public.siswa.show', $p->siswa->id) }}" class="group text-center w-44 flex-shrink-0">
                                    <div class="relative mb-4">
                                        @if($p->siswa->foto)
                                            <img src="{{ asset('storage/'.$p->siswa->foto) }}" class="w-full aspect-[3/4] object-cover rounded-2xl shadow-lg group-hover:shadow-2xl transition-shadow duration-300">
                                        @else
                                            <div class="w-full aspect-[3/4] rounded-2xl bg-navy text-white flex items-center justify-center text-4xl font-bold shadow-lg">
                                                {{ substr($p->siswa->nama, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-white rounded-full px-3 py-1 shadow-md border border-[#E5E7EB] whitespace-nowrap">
                                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide">{{ $p->kategori }}</span>
                                        </div>
                                    </div>
                                    <p class="font-bold text-navy mt-3 text-sm group-hover:text-emerald-600 transition-colors line-clamp-1">{{ $p->siswa->nama }}</p>
                                    <p class="text-xs text-[#667085] mt-1 line-clamp-2">{{ $p->judul }}</p>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- AGENDA -->
    @if($agendaList->count())
        <section class="max-w-[1280px] mx-auto px-4 py-12">
            <div class="text-center mb-10">
                <h2 class="h-section">Agenda</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($agendaList as $a)
                    <a href="{{ route('public.agenda.show', $a->id) }}" class="group flex gap-5 items-start border border-[#EDEEF0] rounded-2xl p-5 hover:border-accent-blue/30 hover:shadow-lg transition-all duration-300">
                        <div class="border border-navy/15 rounded-xl w-16 h-16 flex flex-col items-center justify-center flex-shrink-0">
                            <span class="text-[10px] font-bold uppercase text-accent-blue">{{ $a->tanggal->translatedFormat('M') }}</span>
                            <span class="text-2xl font-extrabold text-navy leading-none mt-0.5">{{ $a->tanggal->format('d') }}</span>
                        </div>
                        <div class="pt-1">
                            <p class="text-sm font-bold text-navy group-hover:text-accent-blue transition-colors leading-snug">{{ $a->judul }}</p>
                            <p class="text-xs text-[#667085] mt-1.5">{{ $a->lokasi }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('public.agenda') }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-7 py-3.5 rounded-lg hover:bg-accent-blue transition-colors">Lihat Selengkapnya</a>
            </div>
        </section>
    @endif

        <!-- GALERI -->
    @if($galeriTerbaru->count())
        <section class="max-w-[1280px] mx-auto px-4 py-12" x-data="{ lightbox: null }">
            <div class="text-center mb-10">
                <h2 class="h-section">Galeri Kegiatan</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($galeriTerbaru as $g)
                    <button type="button" @click="lightbox = '{{ asset('storage/'.$g->file) }}'" class="group text-left card-premium overflow-hidden flex flex-col">
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/'.$g->file) }}" class="w-full aspect-square object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <p class="text-sm font-bold text-navy leading-snug line-clamp-2 group-hover:text-accent-blue transition-colors">{{ $g->judul }}</p>
                            <div class="mt-auto pt-3 flex items-center justify-between">
                                @if($g->kategori)
                                    <span class="px-2.5 py-1 rounded-full bg-light-blue text-accent-blue text-[10px] font-bold uppercase tracking-wide">{{ $g->kategori }}</span>
                                @else
                                    <span></span>
                                @endif
                                <span class="text-[10px] text-[#667085]">{{ $g->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('public.galeri') }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-7 py-3.5 rounded-lg hover:bg-accent-blue transition-colors">Lihat Selengkapnya</a>
            </div>

            <template x-teleport="body">
                <div x-show="lightbox" x-cloak @click="lightbox = null" @keydown.escape.window="lightbox = null"
                     class="fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4 md:p-10"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <button @click="lightbox = null" class="absolute top-5 right-5 md:top-8 md:right-8 text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm w-11 h-11 rounded-full flex items-center justify-center transition-colors z-10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div @click.stop
                         x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white/5 backdrop-blur-sm rounded-2xl p-2 md:p-3 shadow-2xl ring-1 ring-white/10 max-w-3xl w-full">
                        <img :src="lightbox" class="w-full max-h-[75vh] object-contain rounded-xl">
                    </div>
                </div>
            </template>
        </section>
    @endif

    <!-- PPDB CTA -->
    <section class="relative bg-gradient-to-br from-navy to-navy-dark text-white overflow-hidden texture-rows">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-accent-teal/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent-blue/10 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>

        <div class="relative max-w-2xl mx-auto px-4 py-12 text-center">
            <p class="inline-flex items-center gap-2.5 text-xs font-bold tracking-[0.18em] uppercase text-white/70 mb-4">Pendaftaran Dibuka</p>
            <h2 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight leading-tight">Penerimaan Peserta<br class="hidden md:block"> Didik Baru</h2>
            <div class="w-10 h-px bg-emerald-500 mx-auto mb-4"></div>
            <p class="text-white/60 text-base leading-relaxed mb-8 max-w-md mx-auto">Bergabunglah bersama SMK Fadlun Nafis Bangsri dan wujudkan masa depan yang siap kerja, siap kuliah, dan siap usaha.</p>
            <a href="{{ route('public.ppdb') }}" class="group inline-flex items-center gap-2 border border-white/30 text-white px-9 py-4 rounded-lg font-bold text-sm hover:bg-white hover:text-navy transition-all duration-300">
                Info PPDB
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
            </a>
        </div>
    </section>
</x-layouts.public>