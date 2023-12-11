<?php

namespace Neon\Site;

use Illuminate\Database\Console\DumpCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Neon\Site\Http\Middleware\SiteMiddleware;

class Site
{
  private $model = \Neon\Site\Models\Site::class;

  private $sites = null;

  private $site = null;

  private $locales = null;

  private $locale = null;

  public function __construct()
  {
    /** 
     * @var string The name of the clas what represents site.
     */
    $this->model    = config('neon-site.model');

    // Fill up the sites...
    $this->boot();
  }

  private function boot()
  {
    if (Cache::has('neon-site') && config('neon-site.cache', true))
    {
      $this->sites = Cache::get('neon-site');
    } else {
      // Store all sites to cache.
      $this->sites = $this->model::all();
      
      if ($this->sites?->count() && config('neon-site.cache', true))
      {
        Cache::put('neon-site', $this->sites);
      }
    }
  }

  /** 
   * Try to find site by domain.
   * 
   * @param string $prefix Website's prefix getting from the Router.
   * 
   * @return \Neon\Site\Models\Site|mixed|null Returns the Neon's Site model by
   * default and null if no Site record found. Alternatively developers can use
   * different model to represent site.
   * 
   * @see doc
   */
  public function findByDomain(string $host)
  {
    return $this->sites->filter(function ($item, $key) use ($host) {
      $need     = false;

      $match = Str::of($host)->match($item->getDomainPattern());

      if ($host == $match && $item->locale == app()->getLocale()) {
        $need = true;
      }
    
      return $need;
    })?->first();
  }

  /** 
   * Try to find site by prefix.
   * 
   * @param string $prefix Website's prefix getting from the Router.
   * 
   * @return \Neon\Site\Models\Site|mixed|null Returns the Neon's Site model by
   * default and null if no Site record found. Alternatively developers can use
   * different model to represent site.
   * 
   * @see doc
   */
  public function findByPrefix(string $prefix)
  {
    return $this->sites->filter(function ($item, $key) use ($prefix) {
      $need     = false;

      /** Clean it up...
       */
      $prefix = Str::of($prefix)->trim('/');

      $match = Str::of($prefix)->match($item->getPrefixPattern());

      if ($prefix == $match && $item->locale == app()->getLocale()) {
        $need = true;
      }
    
      return $need;
    })?->first();
  }

  public function findOrDefault(Request $request)
  {
    $site = $this->findByDomain($request->host()) ?: $this->findByPrefix(Route::current()->getPrefix());
    
    /** If site can't find by domain neither prefix, we just getting the default
     * one. Locale also should match.
     */
    if (is_null($site)) {
      $site = $this->sites->filter(function ($item, $key) {
        if ($item->default === true && $item->locale == app()->getLocale()) {
          return true;
        }
      })
        ->first();
    }

    if (!is_null($site)) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function current()
  {
    return $this->site;
  }
}
