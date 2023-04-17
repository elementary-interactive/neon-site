<?php

namespace Neon\Site;

use Illuminate\Support\Facades\Cache;

class Site
{
  const DRIVER_FILE = 'file';
  const DRIVER_DATABASE = 'database';

  private $driver = self::DRIVER_FILE;

  private $class = \Neon\Site\Models\Site::class;

  private $sites = null;

  private $site = null;

  private $protected = false;

  public function __construct()
  {
    /** Getting driver's value to know from where we should take the list of sites.
     * @var string Identify resource from where sites should be filled up.
     */
    $this->driver   = config('site.driver');

    /** 
     * @var string The name of the clas what represents site.
     */
    $this->class    = config('site.model');

    // Fill up the sites...
    $this->boot();
  }

  private function boot()
  {
    if (Cache::has('neon-site') && config('site.cache', true))
    {
      $this->sites = Cache::get('neon-site');
    } else {
      if ($this->driver === self::DRIVER_DATABASE)
      {
        $this->sites = $this->class::all();
      }
      if ($this->driver === self::DRIVER_FILE)
      {
        $this->sites = collect();

        $sites = collect(config('site.hosts'));
        $sites->each(function($item, $key) {
          // Set the key.
          $item[(new $this->class)->getKeyName()] = $key;
          // Push to collection.
          $this->sites->push(new $this->class($item));
        });
      }

      if ($this->sites->count() && config('site.cache', true)) {
        Cache::put('neon-site', $this->sites);
      }
    }
    
  }

  public function findByPrefix($prefix)
  {
    $site = $this->sites->filter(function ($item, $key) use ($prefix) {
      if (is_array($item->prefixes) && in_array($prefix, $item->prefixes) && $item->locale === app()->getLocale()) {
        return true;
      }
    })
      ->first();

    if (!is_null($site) && !$this->protected) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function findByDomain($host)
  {
    $site = $this->sites->filter(function ($item, $key) use ($host) {
      if (is_array($item->domains) && in_array($host, $item->domains) && $item->locale === app()->getLocale()) {
        return true;
      }
    })
      ->first();

    if (!is_null($site) && !$this->protected) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function findOrDefault($host, $prefix = '')
  {
    $site = $this->findByPrefix($prefix);

    if (is_null($site))
    {
      $site = $this->findByDomain($host);
    }

    if (is_null($site))
    {
      $site = $this->sites->filter(function ($item, $key) {
        if ($item->default === true) {
          return true;
        }
      })
        ->first();
    }

    if (!is_null($site) && !$this->protected) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function current()
  {
    return $this->site;
  }
}
