<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sedang Perbaikan — {{ $pengaturan->nama_sekolah ?? 'Website Sekolah' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F7F8FA; color: #172033; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 24px; }
        .box { max-width: 420px; }
        h1 { font-size: 1.5rem; font-weight: 800; margin-bottom: 8px; }
        p { color: #667085; font-size: 0.95rem; line-height: 1.6; }
        .icon { font-size: 2.5rem; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="box">
        {{-- <div class="icon">🛠️</div> --}}
        <h1>Website Sedang Dalam Perbaikan</h1>
        <p>Mohon maaf, {{ $pengaturan->nama_sekolah ?? 'website sekolah' }} sedang dalam proses pemeliharaan. Silakan coba kembali beberapa saat lagi.</p>
    </div>
</body>
</html>