<?php

namespace Neon\Site;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Neon\Site\Http\Middleware\SiteMiddleware;

class Site
{
  const DRIVER_FILE = 'file';
  const DRIVER_DATABASE = 'database';

  private $driver = self::DRIVER_FILE;

  private $model = \Neon\Site\Models\Site::class;

  private $sites = null;

  private $site = null;

  private $locales = null;

  private $locale = null;

  public function __construct()
  {
    /** Getting driver's value to know from where we should take the list of sites.
     * @var string Identify resource from where sites should be filled up.
     */
    $this->driver   = config('site.driver');

    /** 
     * @var string The name of the clas what represents site.
     */
    $this->model    = config('site.model');

    /** 
     * @var array The available locales.
     */
    $this->locales = config('site.available_locales');

    // Fill up the sites...
    $this->boot();
  }

  private function boot()
  {
    if (Cache::has('neon-site') && config('site.cache', true)) {
      $this->sites = Cache::get('neon-site');
    } else {

      if ($this->driver === self::DRIVER_DATABASE) {
        $this->sites = $this->model::all();
      }
      if ($this->driver === self::DRIVER_FILE) {
        $this->sites = collect();

        $sites = collect(config('site.hosts'));
        $sites->each(function ($item, $key) {
          // Set the key.
          $item[(new $this->model)->getKeyName()] = $key;
          // Push to collection.
          $this->sites->push(new $this->model($item));
        });
      }

      if ($this->sites->count() && config('site.cache', true)) {
        Cache::put('neon-site', $this->sites);
      }
    }
  }

  public function findByDomain($host)
  {
    // $site = $this->sites->filter(function ($item, $key) use ($host) {
    //   $need = false;
    //   $domains = '';

    //   if (is_array($item->domains)) {
    //     foreach ($item->domains as $key => $domain) {
    //       $item->domains[$key] = addslashes($domain);
    //     }
    //   }

    //   $domains = (is_array($item->domains)) ? implode('|', $item->domains) : $item->domains;


    //   if (!Str::of($domains)->startsWith('/')) {
    //     $domains = "/{$domains}/";
    //   }

    //   $match = (Str::of($domain)->startsWith('/')) ? Str::of($host)->match($domain) : $domain;
    //   if ($host == $match) {
    //     $need = true;
    //   }

    //   return $need;
    // })
    //   ->first();

    // if (!is_null($site)) {
    //   $this->site = $site;
    // }

    return $this->current();
  }
  
  public function find($slug)
  {
    $locale = $this->locale;

    $site = $this->sites->filter(function ($item, $key) use ($slug, $locale) {
      if (($item->slug === $slug) && (is_null($locale) || $item->locale === $locale))
      {
        return true;
      }
    })
      ->first();

    if (!is_null($site)) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function findOrDefault($slug)
  {
    $site = $this->find($slug);

    if (is_null($site)) {
      $site = $this->sites->filter(function ($item, $key) {
        if ($item->default === true) {
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

  /** Creating Laravel route patterns.
   * 
   * @return void;
   */
  public function patterns()
  {
    foreach ($this->sites as $site)
    {
      Route::pattern($site->slug, $site->pattern);
    }
  }

  public function setLocale($locale = null)
  {
    if (empty($locale) || !is_string($locale))
    {
      $locale = request()->segment(1);
    }

    if (!array_key_exists($locale, $this->locales))
    {
      $locale = config('app.locale');
    }

    $this->locale = $locale;
    
    app()->setLocale($locale);

    return $locale;
  }

  public function domain(string $slug, bool $needKey = false): array|string
  {
    return $this->group('domain', $slug, $needKey);
  }

  public function prefix(string $slug, bool $needKey = false): array|string
  {
    return $this->group('prefix', $slug, $needKey);
  }

  /** Creating group value for Laravel routing
   *
   */
  private function group(string $key, string $value, bool $needKey = false): array|string
  {
    return ($needKey === true) ? [$key => "{{$value}}"] : "{{$value}}";
  }
}
