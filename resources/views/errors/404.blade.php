<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-[#F6F7FA] text-[#172033] min-h-screen flex items-center justify-center">
    <div class="text-center">
        <p class="text-5xl font-bold text-navy mb-2">404</p>
        <p class="text-[#667085] mb-6">Halaman tidak ditemukan.</p>
        <a href="{{ route('home') }}" class="bg-navy text-white px-4 py-2 rounded text-sm">Kembali ke Beranda</a>
    </div>
</body>
</html>