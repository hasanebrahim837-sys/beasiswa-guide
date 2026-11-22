<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the language the visitor picked with the flag buttons (stored in the session).
 */
class SetLocale
{
    public const SUPPORTED = ['en', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        // First visit: the site's default language (Arabic); afterwards the visitor's choice.
        $locale = $request->session()->get('locale', config('app.site_locale', 'ar'));

        if (in_array($locale, self::SUPPORTED, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
