<?php

namespace Neon\Site\Http\Middleware;

use Closure;
use Neon\Site\NeonSiteServiceProvider;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        \Site::findOrDefault($request->getHttpHost());

        return $next($request);
    }
}