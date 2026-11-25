<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminEmail = config('app.admin_email');
        $userEmail = $request->user()?->email;

        if (
            ! is_string($adminEmail)
            || $adminEmail === ''
            || ! is_string($userEmail)
            || strcasecmp($userEmail, $adminEmail) !== 0
        ) {
            abort(403);
        }

        return $next($request);
    }
}
