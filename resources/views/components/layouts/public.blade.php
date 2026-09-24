<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $judulHalaman = $title ?? null;
        $judulLengkap = $judulHalaman ? $judulHalaman.' — SMK Fadlun Nafis Bangsri' : 'SMK Fadlun Nafis Bangsri';
        $deskripsiHalaman = $description ?? 'SMK Fadlun Nafis Bangsri — sekolah menengah kejuruan di Bangsri, Jepara.';
        $gambarHalaman = $image ?? null;
    @endphp
    <title>{{ $judulLengkap }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($deskripsiHalaman), 160) }}">
    <meta property="og:title" content="{{ $judulLengkap }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($deskripsiHalaman), 160) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($gambarHalaman)
        <meta property="og:image" content="{{ $gambarHalaman }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@php
    $isHome = request()->routeIs('home');
    $navScrollThreshold = $isHome ? 420 : 160;
    $heroGelap = request()->routeIs('home', 'public.akademik.show', 'public.ekstrakurikuler.show', 'public.prestasi.show');
@endphp
<body class="font-sans antialiased bg-[#F6F7FA] text-navy" x-data="{ mobileOpen: false, scrolled: {{ $heroGelap ? 'false' : 'true' }} }">

    <!-- NAVBAR: transparan hanya di halaman dengan hero foto (beranda & 3 halaman detail), navbar terang di halaman lain.
         Lapisan gradasi gelap tipis selalu ada di belakang saat transparan, supaya logo/menu tetap kebaca
         walau foto hero-nya terang, lalu berubah jadi putih blur pas discroll. -->
    <nav @if($heroGelap)
         x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > {{ $navScrollThreshold }})"
         @endif
         class="fixed top-0 inset-x-0 z-50 transition-all duration-500"
         :class="scrolled ? 'bg-white/85 backdrop-blur-md border-b border-[#E5E7EB] shadow-sm' : 'bg-transparent border-b border-transparent'">
        <div class="max-w-[1280px] mx-auto px-4 flex items-center justify-between h-20"
             :style="!scrolled && 'text-shadow: 0 1px 8px rgba(0,0,0,0.55)'">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-bold flex-shrink-0 transition-colors"
               :class="scrolled ? 'text-navy' : 'text-white'">
                @if($pengaturan->logo)
                    <img src="{{ asset('storage/'.$pengaturan->logo) }}" class="w-10 h-10 rounded-full object-cover transition-all" :class="!scrolled && 'ring-2 ring-white/40'">
                @else
                    <span class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                          :class="scrolled ? 'bg-navy text-white' : 'bg-white/15 backdrop-blur-sm text-white border border-white/30'">SFN</span>
                @endif
                <span class="hidden sm:inline">{{ $pengaturan->nama_sekolah }}</span>
                <span class="sm:hidden">SMK FN</span>
            </a>

            <!-- DESKTOP MENU -->
            @php
                $currentPath = '/' . trim(request()->path(), '/');
                $isActiveUrl = fn ($url) => $url !== '#' && $currentPath === '/' . trim(explode('#', $url)[0], '/');
            @endphp
            <div class="hidden lg:flex items-center gap-1 text-sm font-medium">
                @foreach($menuUtama as $menu)
                    @if($menu->children->isEmpty())
                        @php $active = $isActiveUrl($menu->url); @endphp
                        <a href="{{ $menu->url }}"
                           class="relative px-3.5 py-2 rounded-lg transition-colors"
                           :class="scrolled ? '{{ $active ? "text-accent-blue" : "text-navy hover:bg-[#F6F7FA] hover:text-accent-blue" }}' : '{{ $active ? "text-white" : "text-white/85 hover:text-white hover:bg-white/10" }}'">
                            {{ $menu->label }}
                            @if($active)
                                <span class="absolute left-3.5 right-3.5 -bottom-0.5 h-0.5 rounded-full" :class="scrolled ? 'bg-accent-blue' : 'bg-white'"></span>
                            @endif
                        </a>
                    @else
                        @php $childActive = $menu->children->contains(fn ($c) => $isActiveUrl($c->url)); @endphp
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                    class="relative flex items-center gap-1 px-3.5 py-2 rounded-lg transition-colors"
                                    :class="scrolled ? '{{ $childActive ? "text-accent-blue" : "text-navy hover:bg-[#F6F7FA] hover:text-accent-blue" }}' : '{{ $childActive ? "text-white" : "text-white/85 hover:text-white hover:bg-white/10" }}'">
                                {{ $menu->label }}
                                <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6 8l4 4 4-4"/></svg>
                                @if($childActive)
                                    <span class="absolute left-3.5 right-3.5 -bottom-0.5 h-0.5 rounded-full" :class="scrolled ? 'bg-accent-blue' : 'bg-white'"></span>
                                @endif
                            </button>
                            <div x-show="open" x-transition x-cloak class="absolute left-0 top-full mt-2 w-56 bg-white border border-[#E5E7EB] rounded-xl shadow-xl py-2 z-50">
                                @foreach($menu->children as $child)
                                    @php $childItemActive = $isActiveUrl($child->url); @endphp
                                    <a href="{{ $child->url }}" class="flex items-center gap-2 px-4 py-2 text-sm text-navy hover:bg-[#F6F7FA] hover:text-accent-blue {{ $childItemActive ? 'text-accent-blue font-semibold bg-light-blue/50' : '' }}">
                                        @if($childItemActive)
                                            <span class="w-1 h-1 rounded-full bg-accent-blue"></span>
                                        @endif
                                        {{ $child->label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- TOMBOL SIADIK -->
            <a href="{{ route('public.siadik') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-full transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                SiAdik
            </a>

            <!-- HAMBURGER (mobile) -->
            <button @click="mobileOpen = true" class="lg:hidden p-2 transition-colors" :class="scrolled ? 'text-navy' : 'text-white'">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

    </div>
    </nav>

    <!-- MOBILE MENU: panel geser dari kanan. Sengaja di luar <nav> (bukan
         nested di dalamnya) supaya z-index-nya benar-benar global, tidak
         terkurung di stacking context milik <nav> yang cuma z-50. -->
    <div x-show="mobileOpen" x-cloak class="lg:hidden fixed inset-0 z-[200]">
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="mobileOpen = false" class="absolute inset-0 bg-navy/60 backdrop-blur-[2px]"></div>

        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-250" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 bottom-0 w-[85vw] max-w-[320px] bg-white shadow-2xl flex flex-col">

            <div class="flex items-center gap-3 px-5 py-5 border-b border-[#E5E7EB] flex-shrink-0">
                @if($pengaturan->logo)
                    <img src="{{ asset('storage/'.$pengaturan->logo) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                @else
                    <span class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center text-xs font-bold flex-shrink-0">SFN</span>
                @endif
                <div class="min-w-0">
                    <p class="font-bold text-navy text-sm leading-tight truncate">{{ $pengaturan->nama_sekolah }}</p>
                    @if($pengaturan->tagline)
                        <p class="text-xs text-[#98A2B3] truncate">{{ $pengaturan->tagline }}</p>
                    @endif
                </div>
                <button @click="mobileOpen = false" class="ml-auto flex-shrink-0 w-9 h-9 rounded-full hover:bg-[#F6F7FA] flex items-center justify-center text-[#667085] transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-3 py-3">
                @foreach($menuUtama as $menu)
                    @if($menu->children->isEmpty())
                        @php $active = $isActiveUrl($menu->url); @endphp
                        <a href="{{ $menu->url }}" class="block px-4 py-3 rounded-xl font-medium transition-colors {{ $active ? 'bg-[#F6F7FA] text-navy' : 'text-navy hover:bg-[#F6F7FA]' }}">{{ $menu->label }}</a>
                    @else
                        @php $childActive = $menu->children->contains(fn ($c) => $isActiveUrl($c->url)); @endphp
                        <div x-data="{ open: {{ $childActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl font-medium transition-colors {{ $childActive ? 'bg-[#F6F7FA] text-navy' : 'text-navy hover:bg-[#F6F7FA]' }}">
                                {{ $menu->label }}
                                <svg class="w-4 h-4 text-[#98A2B3] transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6 8l4 4 4-4"/></svg>
                            </button>
                            <div x-show="open" x-transition x-cloak class="pl-3">
                                @foreach($menu->children as $child)
                                    @php $childItemActive = $isActiveUrl($child->url); @endphp
                                    <a href="{{ $child->url }}" class="block px-4 py-2.5 rounded-xl text-sm transition-colors {{ $childItemActive ? 'text-accent-blue font-semibold' : 'text-[#475467] hover:bg-[#F6F7FA]' }}">{{ $child->label }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="p-4 border-t border-[#E5E7EB] flex-shrink-0">
                <a href="{{ route('public.siadik') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-navy to-accent-blue text-white text-sm font-bold px-4 py-3.5 rounded-xl shadow-lg shadow-accent-blue/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    SiAdik
                </a>
            </div>
        </div>
    </div>

    <main>
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#F7F8FA] border-t border-[#E5E7EB] mt-16">
        <div class="max-w-[1280px] mx-auto px-4 py-14 grid grid-cols-1 md:grid-cols-5 gap-10 text-sm">
            <div class="md:col-span-1">
                <div class="flex items-center gap-2.5 mb-4">
                    @if($pengaturan->logo)
                        <img src="{{ asset('storage/'.$pengaturan->logo) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center text-xs font-bold">SFN</div>
                    @endif
                    <p class="font-bold text-navy">{{ $pengaturan->nama_sekolah }}</p>
                </div>
                <p class="text-[#667085] leading-relaxed mb-3">{{ $pengaturan->alamat ?? 'Bangsri, Jepara, Jawa Tengah' }}</p>
                @if($pengaturan->telepon)
                    <p class="text-xs text-[#667085] font-semibold uppercase tracking-wide mb-1">No Telp</p>
                    <a href="tel:{{ $pengaturan->telepon }}" class="flex items-center gap-1.5 text-navy font-medium hover:text-accent-blue transition-colors mb-4">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11 11 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $pengaturan->telepon }}
                    </a>
                @endif

                <div class="flex items-center gap-2">
                    @if($pengaturan->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_starts_with($pengaturan->whatsapp, '0') ? '62'.substr($pengaturan->whatsapp, 1) : $pengaturan->whatsapp) }}" target="_blank" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.81L2 22l5.42-1.35a9.86 9.86 0 004.62 1.15h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm0 17.93a8.1 8.1 0 01-4.13-1.13l-.3-.18-2.9.73.78-2.83-.2-.3a8.02 8.02 0 01-1.24-4.31c0-4.43 3.6-8.03 8.03-8.03 4.43 0 8.03 3.6 8.03 8.03 0 4.43-3.6 8.02-8.07 8.02zm4.4-6.02c-.24-.12-1.43-.7-1.65-.79-.22-.08-.38-.12-.55.12-.16.24-.63.79-.77.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.44-1.34-1.68-.14-.24-.02-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.33-.76-1.82-.2-.48-.4-.42-.55-.42h-.47c-.16 0-.42.06-.64.3s-.85.83-.85 2.02.87 2.35.99 2.51c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.43-.58 1.63-1.15.2-.56.2-1.04.14-1.15-.06-.1-.22-.16-.46-.28z"/></svg>
                        </a>
                    @endif
                    @if($pengaturan->instagram)
                        <a href="{{ $pengaturan->instagram }}" target="_blank" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
                        </a>
                    @endif
                    @if($pengaturan->facebook)
                        <a href="{{ $pengaturan->facebook }}" target="_blank" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5 21v-7.5h2.5l.5-3h-3V8.5c0-.87.24-1.46 1.5-1.46H16.5V4.34C16.15 4.29 15.03 4.2 13.72 4.2c-2.73 0-4.6 1.67-4.6 4.73v2.57H6.5v3h2.62V21h4.38z"/></svg>
                        </a>
                    @endif
                    @if($pengaturan->tiktok)
                        <a href="{{ $pengaturan->tiktok }}" target="_blank" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 2h-3v13.2c0 1.25-1.02 2.27-2.27 2.27a2.27 2.27 0 01-2.27-2.27c0-1.25 1.02-2.26 2.27-2.26.24 0 .47.03.68.1v-3.1a5.4 5.4 0 00-.68-.04A5.34 5.34 0 005 15.2 5.34 5.34 0 0011.23 20.5 5.34 5.34 0 0015.5 15.2V8.5a6.9 6.9 0 004 1.27v-3.1a3.9 3.9 0 01-3-3.79V2z"/></svg>
                        </a>
                    @endif
                    @if($pengaturan->youtube)
                        <a href="{{ $pengaturan->youtube }}" target="_blank" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.6 7.2s-.2-1.5-.8-2.1c-.8-.8-1.7-.8-2.1-.9C15.9 4 12 4 12 4h0s-3.9 0-6.7.2c-.4 0-1.3.1-2.1.9-.6.6-.8 2.1-.8 2.1S2.2 9 2.2 10.7v1.6c0 1.7.2 3.5.2 3.5s.2 1.5.8 2.1c.8.8 1.8.8 2.3.9 1.7.1 6.5.2 6.5.2s3.9 0 6.7-.2c.4 0 1.3-.1 2.1-.9.6-.6.8-2.1.8-2.1s.2-1.7.2-3.5v-1.6c0-1.7-.2-3.5-.2-3.5zM9.9 14.6V8.9l5.4 2.9-5.4 2.8z"/></svg>
                        </a>
                    @endif
                    <a href="{{ route('home') }}" class="w-9 h-9 rounded-full border border-[#E5E7EB] flex items-center justify-center text-[#667085] hover:border-accent-blue hover:text-accent-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><path stroke="currentColor" stroke-width="1.5" d="M3 12h18M12 3c2.5 2.5 3.5 5.5 3.5 9s-1 6.5-3.5 9c-2.5-2.5-3.5-5.5-3.5-9s1-6.5 3.5-9z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <p class="font-bold text-navy mb-4">Menu Utama</p>
                <ul class="space-y-2.5 text-[#667085]">
                    <li><a href="{{ route('home') }}" class="hover:text-accent-blue transition-colors">Beranda</a></li>
                    <li><a href="{{ route('public.profil') }}" class="hover:text-accent-blue transition-colors">Profil</a></li>
                    <li><a href="{{ route('public.akademik') }}" class="hover:text-accent-blue transition-colors">Akademik</a></li>
                    <li><a href="{{ route('public.prestasi') }}" class="hover:text-accent-blue transition-colors">Prestasi</a></li>
                    <li><a href="{{ route('public.ekstrakurikuler') }}" class="hover:text-accent-blue transition-colors">Ekstrakurikuler</a></li>
                    <li><a href="{{ route('public.kontak') }}" class="hover:text-accent-blue transition-colors">Kontak</a></li>
                </ul>
            </div>

            <div>
                <p class="font-bold text-navy mb-4">Kompetensi Keahlian</p>
                <ul class="space-y-2.5 text-[#667085]">
                    @foreach(\App\Models\Kompetensi::where('aktif', true)->orderBy('urutan')->get() as $k)
                        <li><a href="{{ route('public.akademik.show', $k->slug) }}" class="hover:text-accent-blue transition-colors">{{ $k->nama }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-bold text-navy mb-4">Lain - Lain</p>
                <ul class="space-y-2.5 text-[#667085]">
                    <li><a href="{{ route('public.berita') }}" class="hover:text-accent-blue transition-colors">Berita</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="hover:text-accent-blue transition-colors">Galeri</a></li>
                    <li><a href="{{ route('public.download') }}" class="hover:text-accent-blue transition-colors">Download</a></li>
                    <li><a href="{{ route('public.keuangan') }}" class="hover:text-accent-blue transition-colors">Keuangan</a></li>
                    <li><a href="{{ route('guru.login') }}" class="hover:text-accent-blue transition-colors">Portal Guru</a></li>
                </ul>
            </div>

            <div>
                <p class="font-bold text-navy mb-4">Maps</p>
                @if($pengaturan->latitude && $pengaturan->longitude)
                    <iframe
                        class="w-full h-40 rounded-xl border border-[#E5E7EB]"
                        src="https://maps.google.com/maps?q={{ $pengaturan->latitude }},{{ $pengaturan->longitude }}&z=15&output=embed"
                        loading="lazy"></iframe>
                @else
                    <div class="w-full h-40 rounded-xl border border-dashed border-[#E5E7EB] flex items-center justify-center text-xs text-[#667085] text-center px-3">
                        Koordinat lokasi belum diatur di Admin &gt; Pengaturan
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t border-[#E5E7EB]">
            <div class="max-w-[1280px] mx-auto px-4 py-5 text-center text-xs text-[#667085]">
                {{ now()->year }} &copy; {{ $pengaturan->nama_sekolah }}, All Right Reserved.
            </div>
        </div>
    </footer>

    @if($pengaturan->whatsapp)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', str_starts_with($pengaturan->whatsapp, '0') ? '62'.substr($pengaturan->whatsapp, 1) : $pengaturan->whatsapp) }}"
           target="_blank" rel="noopener"
           class="fixed bottom-5 right-5 z-40 w-14 h-14 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center shadow-xl transition-all hover:scale-105">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.79 14.08c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.88-1.24-4.76-4.14-4.9-4.33-.14-.19-1.17-1.56-1.17-2.98 0-1.42.74-2.11 1-2.4.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.41-.07.64.49.24.58.81 2 .88 2.14.07.15.11.32.02.51-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.16-.19.68-.79.87-1.06.18-.27.37-.22.62-.13.25.09 1.6.75 1.87.89.28.14.46.21.53.32.07.12.07.68-.17 1.36z"/></svg>
        </a>
    @endif

    @livewireScripts
</body>
</html>