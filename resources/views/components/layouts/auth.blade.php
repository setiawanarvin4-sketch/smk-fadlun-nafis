<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') — {{ $pengaturan->nama_sekolah }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen grid md:grid-cols-2 bg-[#F4F5F7]">

        <!-- PANEL KIRI: identitas sekolah, gradient mesh + blob dekoratif -->
        <div class="relative hidden md:flex flex-col justify-between text-white p-12 overflow-hidden bg-navy">
            <!-- gradient mesh layer -->
            <div class="absolute inset-0" style="background:
                radial-gradient(circle at 15% 15%, rgba(14,122,122,0.55), transparent 45%),
                radial-gradient(circle at 85% 30%, rgba(201,138,44,0.25), transparent 40%),
                radial-gradient(circle at 30% 90%, rgba(27,107,58,0.6), transparent 50%),
                linear-gradient(160deg, #16211C 0%, #123524 55%, #0E1A14 100%);">
            </div>

            <!-- blob blur dekoratif -->
            <div class="absolute -top-16 -left-16 w-72 h-72 bg-accent-teal/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-blue/20 rounded-full blur-3xl animate-blob" style="animation-delay:2s"></div>

            <!-- grid pattern halus -->

            <a href="{{ route('home') }}" class="relative flex items-center gap-3 animate-fade-in-up">
                @if($pengaturan->logo)
                    <img src="{{ asset('storage/'.$pengaturan->logo) }}" alt="Logo {{ $pengaturan->nama_sekolah }}" class="w-12 h-12 rounded-xl object-cover ring-2 ring-white/25 shadow-lg">
                @else
                    <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center font-extrabold shadow-lg">SFN</div>
                @endif
                <span class="font-bold">{{ $pengaturan->nama_sekolah }}</span>
            </a>

            <div class="relative animate-fade-in-up" style="animation-delay:0.1s">
                <p class="text-xs font-bold tracking-[0.22em] uppercase text-white/50 mb-5">Portal Internal</p>
                <h1 class="text-5xl font-extrabold tracking-tight leading-[1.05] mb-5">
                    Kelola<br>Sekolah<br><span class="bg-gradient-to-r from-accent-teal to-white bg-clip-text text-transparent">Lebih Mudah.</span>
                </h1>
                <p class="text-white/55 max-w-sm leading-relaxed mb-8">{{ $pengaturan->tagline ?? 'Sistem informasi & absensi guru SMK Fadlun Nafis Bangsri, dalam satu portal terpadu.' }}</p>

                <div class="flex flex-col gap-3">
                    @foreach(['Data siswa & guru real-time', 'Absensi digital tiap sesi pelajaran', 'Keamanan berlapis dengan verifikasi 2 langkah'] as $fitur)
                        <div class="flex items-center gap-2.5 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-accent-teal/25 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-accent-teal" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            {{ $fitur }}
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="relative text-white/30 text-xs animate-fade-in-up" style="animation-delay:0.2s">&copy; {{ now()->year }} {{ $pengaturan->nama_sekolah }}</p>
        </div>

        <!-- PANEL KANAN: form -->
        <div class="flex items-center justify-center p-6 md:p-12">
            <div class="w-full max-w-sm animate-fade-in-up" style="animation-delay:0.15s">
                <div class="md:hidden flex items-center gap-3 mb-8 justify-center">
                    @if($pengaturan->logo)
                        <img src="{{ asset('storage/'.$pengaturan->logo) }}" alt="Logo {{ $pengaturan->nama_sekolah }}" class="w-12 h-12 rounded-xl object-cover">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-extrabold">SFN</div>
                    @endif
                    <span class="font-bold text-navy">{{ $pengaturan->nama_sekolah }}</span>
                </div>

                <div class="bg-white rounded-3xl shadow-[0_20px_60px_-15px_rgba(16,24,40,0.15)] border border-[#EDEEF0] overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-accent-blue via-accent-teal to-accent-blue"></div>
                    <div class="p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>