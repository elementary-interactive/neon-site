<?php

namespace Neon\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Neon\Attributables\Models\Traits\Attributables;
use Neon\Models\Traits\Uuid;

class Site extends Model
{
  use Attributables;
  use Uuid;

  protected $fillable = ['domains'];

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
    'domains' => 'array',
    'default' => 'boolean',
  ];

}
