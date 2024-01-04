<?php

namespace Neon\Site\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Masterminds\HTML5\Exception as HTML5Exception;
use Neon\Attributable\Models\Traits\Attributable;
use Neon\Models\Traits\Uuid;
use Neon\Site\Models\Interfaces\Site as SiteInterface;

class Site extends Model implements SiteInterface
{
  use Attributable;
  use SoftDeletes;
  use Uuid;

  /**
   * The model's properties what are able to being filled by mass updates.
   * 
   * @var array
   */
  protected $fillable = [
    'id',
    'title',
    'slug',
    'domains',
    'prefixes',
    'locale',
    'is_default'
  ];

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'is_default' => false,
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'title'       => 'string',
    'slug'        => 'string',
    'domains'     => 'array',
    'prefixes'    => 'array',
    'is_default'  => 'boolean',
  ];

  public function setlocaleAttribute($locale)
  {
    // if (class_exists(\Mcamara\LaravelLocalization\LaravelLocalization::class) && !in_array($locale, \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLanguagesKeys()))
    // {
    //   throw new \Neon\Site\Exceptions\NotSupportedLocale($locale);
    // }
    // else
    // {
      $this->attributes['locale'] = $locale;
    // }
  }

  // /**
  //  * @return array
  //  */
  // public function getDomainsAttribute(): array
  // {
  //   return explode(',', $this->attributes['domains']);
  // }

  /**
   */
  // public function setDomainsAttribute($domains): array
  // {
  //   dd($domains);
  //   return explode(',', $this->attributes['domains']);
  // }

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
