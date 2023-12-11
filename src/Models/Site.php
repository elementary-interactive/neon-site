<?php

namespace Neon\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Neon\Attributable\Models\Traits\Attributable;
use Neon\Models\Traits\Uuid;
use Neon\Site\Models\Interfaces\Site as SiteInterface;

class Site extends Model implements SiteInterface
{
  // use Attributable;
  use Uuid;

  /**
   * The model's properties what are able to being filled by mass updates.
   * 
   * @var array
   */
  protected $fillable = [
    'id',
    'domains',
    'prefixes',
    'default'
  ];

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'default' => false,
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'domains'   => 'array',
    'prefixes'  => 'array',
    'default'   => 'boolean',
  ];

  /**
   * @return string
   */
  public function getDomainPattern(): string
  {
    $domains = (is_array($this->domains)  && !empty($this->domains)) ? implode('|', $this->domains) : $this->domains;
    if (!Str::of($domains)->startsWith('/')) {
      $domains = "/{$domains}/im";
    }

    return $domains;
  }

  /** Getting the prefix pattern of the site. This is used Site Middleware, what
   * recognizes the Site where we are and helps to find in the database.
   * 
   * @return string
   */
  public function getPrefixPattern(): string
  {
    $prefixes = (is_array($this->prefixes)  && !empty($this->prefixes)) ? implode('|', $this->prefixes) : $this->prefixes;
    if (!Str::of($prefixes)->startsWith('/')) {
      $prefixes = "/{$prefixes}/im";
    }

    return $prefixes;
  }
}
