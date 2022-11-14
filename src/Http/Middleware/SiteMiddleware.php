<?php

namespace Neon\Site\Http\Middleware;

use Closure;
use Neon\Site\NeonSiteServiceProvider;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        

        $site = \Site::findOrDefault($request->getHttpHost());

        dd($request->getHttpHost(), $request, $site);

        return $next($request);
    }
}