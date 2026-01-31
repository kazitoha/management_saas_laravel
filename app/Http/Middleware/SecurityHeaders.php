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

        // 1. Prevent Clickjacking: prevents your site from being put in an iframe
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. Prevent MIME Sniffing: stops browser from guessing file types
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. XSS Protection: Legacy header, but good for older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 4. Referrer Policy: Controls how much info is sent when users click links leaving your site
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Strict Transport Security (HSTS): Forces HTTPS (Only enable if you have SSL)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // 6. Content Security Policy (CSP)
        // This is complex. Since you are using CDNs (Tailwind, Google Fonts), you must allow them.
        // warning: 'unsafe-inline' and 'unsafe-eval' are not ideal for strict security, 
        // but required for Tailwind CDN and some JS libraries.
        $csp = "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "img-src 'self' data: https:; " . // data: allows base64 images
            "connect-src 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
