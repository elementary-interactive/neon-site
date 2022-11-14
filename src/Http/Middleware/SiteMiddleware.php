<?php

namespace Neon\Site\Http\Middleware;

use Closure;
use Neon\Site\NeonSiteServiceProvider;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        dd($request->getHttpHost(), $request);

        NeonSiteService::where('host', $request->getHttpHost());

        return $next($request);
    }
}