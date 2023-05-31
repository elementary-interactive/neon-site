<?php

namespace Neon\Site\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Neon\Site\NeonSiteServiceProvider;

class SiteMiddleware
{
    public function handle($request, Closure $next)
    {
        dump(func_get_args());
        dump($request->route('domain'));
        dump('Hello handler, very default');
        // app('site')->findOrDefault($request->getHttpHost(), $request->segment(1));

        return $next($request);
    }

    public static function domain($slug)
    {
        app('site')->findOrDefault($slug);
    }

    public static function prefix($prefix)
    {
        dump('Hello, should check prefix: '.request()->segment(1), $prefix      );
    }

    public static function locale()
    {
        dump('Hello, should check locale: '.request()->segment(1));
    }
}