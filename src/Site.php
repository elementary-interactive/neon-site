<?php

namespace Neon\Site;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Neon\Site\Exceptions\DomainNotSetProperlyException;

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
    if (Cache::has('neon-site') && config('neon-site.cache', true)) {
      $this->sites = Cache::get('neon-site');
    } else {
      // Store all sites to cache.
      $this->sites = $this->model::all();

      if ($this->sites?->count() && config('neon-site.cache', true)) {
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

      $match = Str::of($host)->matchAll($item->getDomainPattern());

      if ($match->count() >= 1) {
        $need = true;
      }

      return $need;
    });
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
  public function findByPrefix(string|null $prefix = null, Collection|null $filtered_sites = null)
  {
    if (!$filtered_sites)
    {
      $filtered_sites = $this->sites;
    }
    
    return $filtered_sites->filter(function ($item, $key) use ($prefix) {
      $need     = false;

      /** Clean it up...
       */
      $prefix = Str::of($prefix)->trim('/');

      /** Check only prefixes are set.
       */
      if ($item->getPrefixPattern())
      {
        $match = Str::of($prefix)->matchAll($item->getPrefixPattern());

        if ($match->count() >= 1) {
          $need = true;
        }
      }

      return $need;
    })?->first();
  }

  public function findOrDefault(Request $request)
  {
    $site = null;
    $available_sites = $this->findByDomain($request->host());

    if ($available_sites->count() > 1) {
      /** If more domanis matching, we try to get site by prefix.
       */
      $site = $this->findByPrefix($request->segment(1), $available_sites);
    } elseif ($available_sites->count() == 1) {
      $site = $available_sites->first();
    }

    /** If site can't find by domain neither prefix, we just getting the default
     * one. Locale also should match.
     */
    if (is_null($site)) {
      $this->site = $this->sites->filter(function ($item, $key) {
        if ($item->default === true) {
          return true;
        }
      })->first();
    } else {
      $this->site = $site;
    }

    if (!$this->site) {
      throw new DomainNotSetProperlyException($request->host());
    }

    /** Set locale.
     */
    app()->setLocale($site->locale);

    return $this->site;
  }

  public function current()
  {
    if (!$this->site) {
      $this->findOrDefault(request());
    }
    return $this->site;
  }
}
