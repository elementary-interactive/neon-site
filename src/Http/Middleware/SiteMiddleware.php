<?php

namespace Neon\Site\Http\Middleware;

use Closure;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        dd($request);

        return $next($request);
    }
}