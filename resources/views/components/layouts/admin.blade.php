<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Admin SMK Fadlun Nafis</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-[#F7F8FA] dark:bg-[#0B1210] text-[#172033] dark:text-gray-200 transition-colors" x-data="{ sidebarOpen: false }">    <div class="flex min-h-screen">

        <!-- overlay mobile -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden"></div>

        <aside class="w-72 bg-white dark:bg-[#0F1613] text-[#172033] dark:text-gray-200 border-r border-[#E5E7EB] dark:border-gray-800 flex-shrink-0 fixed md:sticky top-0 h-screen z-50 flex flex-col transition-transform duration-300"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div class="p-6 border-b border-[#E5E7EB] dark:border-gray-800">
                <div class="flex items-center gap-3">
                    @if($pengaturan->logo)
                        <img src="{{ asset('storage/'.$pengaturan->logo) }}" alt="Logo {{ $pengaturan->nama_sekolah }}" class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/20">
                    @else
                        <div class="w-11 h-11 rounded-xl bg-navy/5 border border-navy/10 flex items-center justify-center font-extrabold text-sm">SFN</div>
                    @endif
                    <div>
                        <p class="font-bold text-sm leading-tight">{{ $pengaturan->nama_sekolah }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">Panel Admin</p>
                    </div>
                </div>
            </div>

            <nav id="admin-sidebar-nav" class="flex-1 overflow-y-auto p-4 space-y-0.5 text-sm scrollbar-hide">
                @php
                    $isActive = fn($routeName) => request()->routeIs($routeName);
                    $linkClass = fn($routeName) => 'relative flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 font-medium '
                        .($isActive($routeName) ? 'bg-navy text-white shadow-lg nav-active' : 'text-[#475467] dark:text-gray-400 hover:bg-[#F6F7FA] dark:hover:bg-gray-800 hover:text-navy dark:hover:text-white');
                @endphp
                @if(auth()->user()->role === 'jurnalistik')
                    <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass('admin.dashboard') }}">Dashboard</a>                    <a href="{{ route('admin.berita') }}" class="{{ $linkClass('admin.berita') }}">Berita</a>
                    <a href="{{ route('admin.prestasi') }}" class="{{ $linkClass('admin.prestasi') }}">Prestasi</a>
                    <a href="{{ route('admin.galeri') }}" class="{{ $linkClass('admin.galeri') }}">Galeri</a>
                    <a href="{{ route('admin.agenda') }}" class="{{ $linkClass('admin.agenda') }}">Agenda</a>
                    <a href="{{ route('admin.hero-slider') }}" class="{{ $linkClass('admin.hero-slider') }}">Hero Slider</a>
                @else

                <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass('admin.dashboard') }} mb-4">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Data Master</p>
                @foreach([
                    ['admin.siswa', 'Siswa'],
                    ['admin.guru', 'Guru'],
                    ['admin.kelas', 'Kelas'],
                    ['admin.kenaikan-kelas', 'Kenaikan Kelas'],
                    ['admin.kompetensi', 'Kompetensi'],
                    ['admin.alumni', 'Testimoni Alumni'],
                    ['admin.faq', 'FAQ'],
                    ['admin.pengumuman-guru', 'Pengumuman Guru'],
                    ['admin.mata-pelajaran', 'Mata Pelajaran'],
                    ['admin.jadwal-pelajaran', 'Jadwal Pelajaran'],
                    ['admin.jadwal-pengganti', 'Jadwal Pengganti'],
                ] as [$route, $label])
                    <a href="{{ route($route) }}" class="{{ $linkClass($route) }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive($route) ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        {{ $label }}
                    </a>
                @endforeach

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Konten</p>
                @foreach([
                    ['admin.berita', 'Berita'],
                    ['admin.galeri', 'Galeri'],
                    ['admin.prestasi', 'Prestasi'],
                    ['admin.agenda', 'Agenda'],
                    ['admin.ekstrakurikuler', 'Ekstrakurikuler'],
                    ['admin.hero-slider', 'Hero Slider'],
                    ['admin.pengumuman', 'Pengumuman Beranda'],
                    ['admin.statistik-sekolah', 'Statistik Sekolah'],
                ] as [$route, $label])
                    <a href="{{ route($route) }}" class="{{ $linkClass($route) }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive($route) ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        {{ $label }}
                    </a>
                @endforeach

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Dokumen & Keuangan</p>
                @foreach([
                    ['admin.dokumen', 'Dokumen'],
                    ['admin.keuangan', 'Laporan Keuangan'],
                ] as [$route, $label])
                    <a href="{{ route($route) }}" class="{{ $linkClass($route) }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive($route) ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        {{ $label }}
                    </a>
                @endforeach

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Absensi</p>
                <a href="{{ route('admin.absensi') }}" class="{{ $linkClass('admin.absensi') }}">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.absensi') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                    Rekap Absensi
                </a>
                <a href="{{ route('admin.hari-khusus') }}" class="{{ $linkClass('admin.hari-khusus') }}">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.hari-khusus') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                    Hari Khusus
                </a>

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Website</p>
                @foreach([
                    ['admin.profil-sekolah', 'Profil Sekolah'],
                    ['admin.ppdb', 'PPDB'],
                    ['admin.siadik', 'SiAdik'],
                    ['admin.menu-navigasi', 'Menu Navigasi'],
                    ['admin.pengaturan', 'Pengaturan'],
                ] as [$route, $label])
                    <a href="{{ route($route) }}" class="{{ $linkClass($route) }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive($route) ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        {{ $label }}
                    </a>
                @endforeach

                <p class="text-gray-400 text-[10.5px] uppercase font-bold tracking-wider mt-6 mb-1.5 px-3.5">Sistem</p>
                <a href="{{ route('admin.activity-log') }}" class="{{ $linkClass('admin.activity-log') }}">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.activity-log') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                    Log Aktivitas
                </a>
                                <a href="{{ route('admin.login-log') }}" class="{{ $linkClass('admin.login-log') }}">
                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.login-log') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                    Log Login
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.user') }}" class="{{ $linkClass('admin.user') }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.user') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        Kelola Akun
                    </a>
                    <a href="{{ route('admin.backup-monitoring') }}" class="{{ $linkClass('admin.backup-monitoring') }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $isActive('admin.backup-monitoring') ? 'bg-accent-blue' : 'bg-gray-300' }}"></span>
                        Monitoring Backup
                    </a>
                @endif
                @endif
            </nav>

            <div class="p-4 border-t border-[#E5E7EB] dark:border-gray-800">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 text-[#475467] dark:text-gray-400 hover:text-navy dark:hover:text-white text-xs px-3 py-2.5 rounded-xl border border-[#E5E7EB] dark:border-gray-700 hover:border-navy/20 hover:bg-[#F6F7FA] dark:hover:bg-gray-800 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website Publik
                </a>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <header class="bg-white/80 dark:bg-[#0F1613]/80 backdrop-blur-md border-b border-[#E5E7EB] dark:border-gray-800 h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
                <button @click="sidebarOpen = true" class="md:hidden text-navy p-2">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <p class="text-sm text-[#667085] hidden md:block font-medium">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="flex items-center gap-4 ml-auto">
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen"
                            class="relative w-10 h-10 rounded-xl border border-[#E5E7EB] dark:border-gray-700 flex items-center justify-center text-[#667085] dark:text-gray-300 hover:bg-[#F6F7FA] dark:hover:bg-gray-800 transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @if($notifAdmin['total'] > 0)
                                <span class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $notifAdmin['total'] > 9 ? '9+' : $notifAdmin['total'] }}</span>
                            @endif
                        </button>
                        <div x-show="notifOpen" x-cloak @click.outside="notifOpen = false" x-transition
                            class="absolute right-0 top-full mt-2 w-72 bg-white dark:bg-[#0F1613] rounded-xl shadow-xl border border-[#E5E7EB] dark:border-gray-700 p-2 z-50 text-sm">
                            @if($notifAdmin['total'] === 0)
                                <p class="text-[#667085] dark:text-gray-400 text-center py-6">Tidak ada notifikasi baru.</p>
                            @else
                                @if($notifAdmin['izinMenunggu'])
                                    <a href="{{ route('admin.absensi') }}" class="block px-3 py-2.5 rounded-lg hover:bg-[#F6F7FA] dark:hover:bg-gray-800 text-navy dark:text-white">
                                        <strong>{{ $notifAdmin['izinMenunggu'] }}</strong> laporan izin guru menunggu persetujuan
                                    </a>
                                @endif
                                @if($notifAdmin['sesiTerlewat'])
                                    <a href="{{ route('admin.absensi') }}" class="block px-3 py-2.5 rounded-lg hover:bg-[#F6F7FA] dark:hover:bg-gray-800 text-navy dark:text-white">
                                        <strong>{{ $notifAdmin['sesiTerlewat'] }}</strong> sesi hari ini belum diisi guru
                                    </a>
                                @endif
                                @if($notifAdmin['loginGagal'])
                                    <a href="{{ route('admin.login-log') }}" class="block px-3 py-2.5 rounded-lg hover:bg-[#F6F7FA] dark:hover:bg-gray-800 text-navy dark:text-white">
                                        <strong>{{ $notifAdmin['loginGagal'] }}</strong> percobaan login gagal 24 jam terakhir
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold leading-tight text-navy">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#667085]">
                        @switch(auth()->user()->role)
                            @case('admin') Administrator @break
                            @case('kepala_sekolah') Kepala Sekolah @break
                            @case('jurnalistik') Tim Jurnalistik @break
                        @endswitch
                    </p>
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

            <main class="p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- <x-success-popup /> --}}

    @livewireScripts
</body>
</html>