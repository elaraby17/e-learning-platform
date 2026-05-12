<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next, string $role)
{
    if (!$request->user() || $request->user()->role !== $role) {
        abort(403, 'غير مسموح لك بالدخول لهذه الصفحة.');
    }
    return $next($request);
}
}
