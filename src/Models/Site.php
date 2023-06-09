<?php

namespace Neon\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Neon\Attributable\Models\Traits\Attributable;
use Neon\Models\Traits\Uuid;

class Site extends Model
{
  use Attributable;
  use Uuid;

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

  public function getPatternAttribute()
  {
    return '('.implode('|', $this->domains).')';
  }
}
