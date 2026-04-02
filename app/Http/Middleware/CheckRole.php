<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'superadmin' && (!$request->user() || !$request->user()->is_super_admin)) {
            abort(403, 'Unauthorized. Superadmin access only.');
        }

        return $next($request);
    }
}
