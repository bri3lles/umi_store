<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menentukan bahasa aktif aplikasi (EN/ID) di setiap request.
 *
 * Prioritas:
 * 1. Kalau ada di session ('locale'), pakai itu (artinya user sudah pernah memilih).
 * 2. Kalau tidak ada, pakai bahasa default aplikasi (config('app.locale')).
 *
 * Locale dipilih lewat link "EN / ID" (lihat routes/web.php -> lang.switch)
 * yang disimpan ke session supaya tetap konsisten selama sesi berlangsung.
 */
class SetLocale
{
    /**
     * Daftar locale yang didukung aplikasi.
     * Tambahkan di sini kalau suatu saat mau menambah bahasa lain.
     */
    public const SUPPORTED_LOCALES = ['en', 'id'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}