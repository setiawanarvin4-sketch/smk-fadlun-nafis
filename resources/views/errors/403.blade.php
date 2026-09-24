<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-[#F6F7FA] text-[#172033] min-h-screen flex items-center justify-center">
    <div class="text-center">
        <p class="text-5xl font-bold text-navy mb-2">403</p>
        <p class="text-[#667085] mb-6">Anda tidak memiliki akses ke halaman ini.</p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('home') }}" class="bg-navy text-white px-4 py-2 rounded text-sm">Kembali ke Beranda</a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="border border-[#E5E7EB] px-4 py-2 rounded text-sm">Keluar & Login Ulang</button>
                </form>
            @endauth
        </div>
    </div>
</body>
</html>