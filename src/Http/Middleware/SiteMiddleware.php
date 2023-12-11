<?php

namespace Neon\Site\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Neon\Site\NeonSiteServiceProvider;

class SiteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** Recognize the site by site singleton.
         */
        app('site')->findOrDefault($request);
       
        return $next($request);
    }
}