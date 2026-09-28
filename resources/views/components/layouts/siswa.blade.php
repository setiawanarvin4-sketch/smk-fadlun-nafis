<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Siswa') — SMK Fadlun Nafis</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-[#F7F8FA] text-navy" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        <!-- overlay mobile -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden"></div>

        <aside class="w-72 bg-white text-[#172033] border-r border-[#E5E7EB] flex-shrink-0 fixed md:sticky top-0 h-screen z-50 flex flex-col transition-transform duration-300"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div class="p-6 border-b border-[#E5E7EB]">
                <div class="flex items-center gap-3">
                    @if($pengaturan->logo)
                        <img src="{{ asset('storage/'.$pengaturan->logo) }}" alt="Logo {{ $pengaturan->nama_sekolah }}" class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/20">
                    @else
                        <div class="w-11 h-11 rounded-xl bg-navy/5 border border-navy/10 flex items-center justify-center font-extrabold text-sm">SFN</div>
                    @endif
                    <div>
                        <p class="font-bold text-sm leading-tight">{{ $pengaturan->nama_sekolah }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">Portal Siswa</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-0.5 text-sm scrollbar-hide">
                @php
                    $isActive = fn($routeName) => request()->routeIs($routeName);
                    $linkClass = fn($routeName) => 'relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 font-medium '
                        .($isActive($routeName) ? 'bg-navy text-white shadow-lg nav-active' : 'text-[#475467] hover:bg-[#F6F7FA] hover:text-navy');
                @endphp

                <a href="{{ route('siswa.dashboard') }}" class="{{ $linkClass('siswa.dashboard') }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Ringkasan
                </a>
                <a href="{{ route('siswa.jadwal') }}" class="{{ $linkClass('siswa.jadwal') }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Pelajaran
                </a>
                <a href="{{ route('siswa.kehadiran') }}" class="{{ $linkClass('siswa.kehadiran') }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12l2 2 4-4"/></svg>
                    Kehadiran
                </a>
                <a href="{{ route('siswa.prestasi') }}" class="{{ $linkClass('siswa.prestasi') }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h6v6M9 7h6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Prestasi
                </a>
                <a href="{{ route('siswa.pengaturan') }}" class="{{ $linkClass('siswa.pengaturan') }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                    Pengaturan
                </a>
            </nav>

            <div class="p-4 border-t border-[#E5E7EB]">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 text-[#475467] hover:text-navy text-xs px-3 py-2.5 rounded-xl border border-[#E5E7EB] hover:border-navy/20 hover:bg-[#F6F7FA] transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website Publik
                </a>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <header class="bg-white/80 backdrop-blur-md border-b border-[#E5E7EB] h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
                <button @click="sidebarOpen = true" class="md:hidden text-navy p-2">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <p class="text-sm text-[#667085] hidden md:block font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="flex items-center gap-4 ml-auto">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold leading-tight text-navy">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#667085]">Siswa</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-teal text-white flex items-center justify-center text-sm font-bold ring-2 ring-light-blue">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm font-medium text-[#667085] hover:text-red-500 hover:border-red-200 hover:bg-red-50 border border-[#E5E7EB] rounded-xl px-4 py-2 transition-all">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-8 max-w-5xl">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>