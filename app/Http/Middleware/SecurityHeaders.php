<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Basic browser protections on every page.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            // The site cannot be shown inside another site's frame (clickjacking / phishing).
            'X-Frame-Options' => 'SAMEORIGIN',
            // Browsers must not guess file types (protects uploaded files).
            'X-Content-Type-Options' => 'nosniff',
            // Do not send full page addresses to other sites.
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            // The site never needs the camera, microphone or location.
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ];

        // Online with HTTPS: always use HTTPS for this site.
        if ($request->isSecure() && app()->environment('production')) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000';
        }

        foreach ($headers as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        return $response;
    }
}
