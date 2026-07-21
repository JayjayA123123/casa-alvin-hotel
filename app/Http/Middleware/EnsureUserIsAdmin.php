<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Bawal makapasok sa /admin/* routes ang mga hindi admin.
     * Ibabalik sa customer dashboard ang mga naka-login pero customer lang.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Hindi ka authorized na makapasok sa Admin area na ito.');
        }

        return $next($request);
    }
}
