<?php

namespace Neon\Site;

use Neon\Site\Models\Site as SiteModel;

class Site
{
  private $primaryKey = 'id';

  private $driver = 'file';

  private $sites = null;

  private $site = null;

  public function __construct()
  {
    /** Getting driver's value to know from where we should take the list of sites.
     */
    $this->driver = config('site.driver');
    $this->sites = ($this->driver === 'file') ? collect(config('site.hosts')) : SiteModel::all();
    $this->class = config('site.class');

    $this->sites->each(function($item, $key) {
      if (!array_key_exists($this->primaryKey, (array) $item))
      {
        if (!is_a($item, $this->class))
        {
          $item = $this->class::create($item);
        }
        
        $item->{$this->primaryKey} = $key;
      }
    });
  }

  public function find($host)
  {
    $site = $this->sites->filter(function ($item, $key) use ($host) {
      if (in_array($host, $item['domains'])) {
        return true;
      }
    })
      ->first();

    if (!is_null($site)) {
      $this->site = $site;
    }

    return $this->current();
  }

  public function findOrDefault($host)
  {
    $site = $this->find($host);

    if (is_null($site))
    {
      /**
       * @todo getting the default one.
       */
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
