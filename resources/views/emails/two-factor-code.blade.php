<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background:#F7F8FA; padding:32px;">
    <div style="max-width:420px;margin:0 auto;background:#fff;border-radius:16px;padding:32px;text-align:center;">
        <p style="color:#667085;font-size:13px;margin:0 0 8px;">SMK Fadlun Nafis Bangsri</p>
        <h2 style="color:#16211C;margin:0 0 16px;">Kode Verifikasi Login</h2>
        <p style="color:#667085;font-size:14px;">Halo {{ $nama }}, gunakan kode berikut untuk menyelesaikan proses login:</p>
        <div style="font-size:36px;font-weight:800;letter-spacing:8px;color:#1B6B3A;background:#EAF3EC;border-radius:12px;padding:16px 0;margin:20px 0;">
            {{ $kode }}
        </div>
        <p style="color:#667085;font-size:13px;">Kode ini berlaku 10 menit. Kalau kamu tidak merasa mencoba login, abaikan email ini.</p>
    </div>
</body>
</html>