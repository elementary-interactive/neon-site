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
        /** Patterns will help to find easily the Site what we should use now...
         * To be able to handle a "default" site, the default value is "default"
         * - this way the site will work with the basic condig file, without any
         * touch.
         * 
         * @var array $patterns Array of used patterns.
         */
        $patterns = ['default'];
        
        if ($request->route())
        { //-- If routes given, we try to analyze that.
            $patterns = array_keys(array_intersect_key($request->route()->parameters(), Route::getPatterns()));

            if (empty($patterns)) {
                $patterns[] = trim($request->route()->action['prefix'], '/');
            }
        }

        if (count($patterns) === 1)
        {
            app('site')->findOrDefault($patterns[0]);
            //- Set up app locale by Site's locale.
            app()->setLocale(app('site')->current()->locale);
        } else {
            throw new \Exception('Too many patterns');
        }

        return $next($request);
    }
}