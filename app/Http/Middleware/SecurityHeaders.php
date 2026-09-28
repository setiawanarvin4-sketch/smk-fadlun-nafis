<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // HSTS: cuma masuk akal dikirim lewat HTTPS (browser mengabaikan header ini
        // di koneksi HTTP biasa), jadi jangan kirim saat dev lokal pakai http://.
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // CSP longgar tapi tetap menutup celah paling umum: skrip/style/gambar dari
        // domain sendiri + Google Fonts (dipakai layout), tanpa <object>/<embed>,
        // dan form cuma boleh submit ke domain sendiri.
        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com",
            "img-src 'self' data: blob: https://img.youtube.com",
            "frame-src 'self' https://www.google.com https://maps.google.com https://www.youtube.com https://www.youtube-nocookie.com",
            "object-src 'none'",
            "frame-ancestors 'self'",
            "form-action 'self'",
        ]));

        return $response;
    }
}