<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * HTTP Security Headers untuk melindungi aplikasi dari serangan
     * Clickjacking, MIME-sniffing, XSS, dan lainnya.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mencegah Clickjacking - halaman tidak bisa di-embed di iframe situs lain
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mencegah browser menebak tipe konten (MIME-type sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Mengaktifkan filter XSS bawaan browser (perlindungan untuk browser lama)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Mengontrol informasi referrer yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Membatasi fitur browser yang tidak digunakan (kamera, mikrofon, geolocation, dll.)
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Strict-Transport-Security - Memaksa browser selalu gunakan HTTPS (aktif di production)
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
