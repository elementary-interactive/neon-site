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
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'domains' => 'array',
  ];
}
