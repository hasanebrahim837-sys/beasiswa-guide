<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Public account registration is closed unless REGISTRATION_ENABLED=true.
 * Students do not need an account to request help; admins are created with: php artisan make:admin
 */
class EnsureRegistrationEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(config('app.registration_enabled'), 404);

        return $next($request);
    }
}
